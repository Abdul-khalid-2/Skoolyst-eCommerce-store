<?php
declare(strict_types=1);

namespace Skoolyst\Services;

use Skoolyst\Core\Database;
use Skoolyst\Core\Validator;
use Skoolyst\Models\Order;
use Skoolyst\Models\OrderItem;

class OrderService {
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

        $deliveryMethod = $data['delivery_method'] ?? 'delivery';
        $deliveryFee = $deliveryMethod === 'pickup' ? 0.0 : (new CartService())->deliveryFee($subtotal);
        $total = $subtotal + $deliveryFee;

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
                'payment_method' => $data['payment_method'] ?? 'cod',
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
}
