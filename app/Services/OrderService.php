<?php
declare(strict_types=1);

namespace Skoolyst\Services;

use Skoolyst\Core\Database;
use Skoolyst\Core\Validator;
use Skoolyst\Models\Order;
use Skoolyst\Models\OrderItem;

class OrderService {
    /** Store Pickup is fully built (single-store detection included) but turned off for now — flip to true to re-enable. */
    public const PICKUP_ENABLED = false;

    private const RULES = [
        'full_name' => 'required|max:160',
        'phone' => 'required|max:30',
        'email' => 'required|email|max:160',
        'address' => 'required|max:255',
        'city' => 'required|max:80',
        'area' => 'max:120',
        'postal_code' => 'max:20',
        'delivery_method' => 'in:delivery,pickup',
        'payment_method' => 'in:cod,online',
    ];

    /**
     * @param list<array> $cartItems
     * @return array{errors: array<string,string>, order: ?array}
     */
    public function place(array $data, array $cartItems, float $subtotal, ?int $userId): array {
        $errors = Validator::make($data, self::RULES);
        if (!$cartItems) {
            $errors['cart'] = 'Your cart is empty.';
        }
        if ($errors) {
            return ['errors' => $errors, 'order' => null];
        }

        // Store Pickup only makes sense when every item comes from the same
        // store, so a tampered/stale request can't force it on a multi-store
        // cart even though the UI already disables that option. Pickup itself
        // is currently switched off altogether (see PICKUP_ENABLED).
        $singleStore = count(array_unique(array_column($cartItems, 'store_id'))) <= 1;
        $deliveryMethod = $data['delivery_method'] ?? 'delivery';
        if ($deliveryMethod === 'pickup' && (!self::PICKUP_ENABLED || !$singleStore)) {
            $deliveryMethod = 'delivery';
        }
        $deliveryFee = $deliveryMethod === 'pickup' ? 0.0 : (new CartService())->deliveryFee($subtotal);
        $total = $subtotal + $deliveryFee;

        // Online payment has no gateway wired up yet — always settle as COD.
        $paymentMethod = 'cod';

        $pdo = Database::connection();
        $pdo->beginTransaction();
        try {
            $orderId = Order::insert([
                'order_number' => $this->generateOrderNumber(),
                'user_id' => $userId,
                'full_name' => $data['full_name'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'address' => $data['address'],
                'city' => $data['city'],
                'area' => $data['area'] ?? null,
                'postal_code' => $data['postal_code'] ?? null,
                'delivery_method' => $deliveryMethod,
                'payment_method' => $paymentMethod,
                'subtotal' => $subtotal,
                'delivery_fee' => $deliveryFee,
                'total' => $total,
                'status' => 'pending',
            ]);

            foreach ($cartItems as $item) {
                OrderItem::insert([
                    'order_id' => $orderId,
                    'product_id' => $item['product_id'],
                    'store_id' => $item['store_id'],
                    'product_name' => $item['name'],
                    'price' => $item['price'],
                    'qty' => $item['qty'],
                    'line_total' => $item['line_total'],
                ]);
            }

            $pdo->commit();
        } catch (\Throwable $e) {
            $pdo->rollBack();
            throw $e;
        }

        return ['errors' => [], 'order' => Order::find($orderId)];
    }

    private function generateOrderNumber(): string {
        do {
            $number = 'ORD-' . strtoupper(bin2hex(random_bytes(4)));
        } while (Order::findByOrderNumber($number));

        return $number;
    }

    /** Every order in the system, for the admin order list. */
    public function paginateForAdmin(array $filters, int $page, int $perPage): array {
        return $this->wrapPagination(Order::paginateForAdmin($filters, max(1, $page), $perPage), $page, $perPage);
    }

    /** Only orders containing at least one of this store's own items. */
    public function paginateForStore(int $storeId, array $filters, int $page, int $perPage): array {
        return $this->wrapPagination(Order::paginateForStore($storeId, $filters, max(1, $page), $perPage), $page, $perPage);
    }

    /** @return array{order: array, items: list<array>}|null */
    public function findForAdmin(int $id): ?array {
        $order = Order::find($id);
        if (!$order) {
            return null;
        }

        return ['order' => $order, 'items' => OrderItem::byOrderId($id)];
    }

    /**
     * @return array{order: array, items: list<array>}|null null when the order
     *     doesn't exist OR has no items belonging to $storeId — a store admin
     *     has no business seeing an order it isn't part of.
     */
    public function findForStore(int $id, int $storeId): ?array {
        $order = Order::find($id);
        if (!$order) {
            return null;
        }

        $items = OrderItem::byOrderAndStore($id, $storeId);
        if (!$items) {
            return null;
        }

        return ['order' => $order, 'items' => $items];
    }

    public function setStatus(int $id, string $status): void {
        Order::updateById($id, ['status' => $status]);
    }

    private function wrapPagination(array $result, int $page, int $perPage): array {
        return [
            'rows' => $result['rows'],
            'total' => $result['total'],
            'page' => max(1, $page),
            'perPage' => $perPage,
            'totalPages' => max(1, (int) ceil($result['total'] / $perPage)),
        ];
    }
}
