<?php
declare(strict_types=1);

namespace Skoolyst\Controllers;

use Skoolyst\Core\Controller;
use Skoolyst\Core\Request;
use Skoolyst\Core\Response;
use Skoolyst\Models\Order;
use Skoolyst\Models\OrderItem;
use Skoolyst\Services\CartService;
use Skoolyst\Services\OrderService;

class CheckoutController extends Controller {
    private CartService $cart;
    private OrderService $orders;

    public function __construct() {
        $this->cart = new CartService();
        $this->orders = new OrderService();
    }

    public function index(): mixed {
        $cart = $this->cart->items();
        if (!$cart['items']) {
            flash('error', 'Your cart is empty. Add some products before checking out.');
            Response::redirect(url('cart'));
        }

        $deliveryFee = $this->cart->deliveryFee($cart['subtotal']);

        return $this->view('checkout/index', [
            'items' => $cart['items'],
            'subtotal' => $cart['subtotal'],
            'deliveryFee' => $deliveryFee,
            'total' => $cart['subtotal'] + $deliveryFee,
            'singleStore' => $this->isSingleStore($cart['items']),
            'pickupEnabled' => OrderService::PICKUP_ENABLED,
            'old' => [],
            'errors' => [],
        ]);
    }

    public function store(): mixed {
        csrf_verify_or_abort();

        $cart = $this->cart->items();
        if (!$cart['items']) {
            flash('error', 'Your cart is empty. Add some products before checking out.');
            Response::redirect(url('cart'));
        }

        $data = Request::all();
        $result = $this->orders->place($data, $cart['items'], $cart['subtotal'], auth_id());

        if ($result['errors']) {
            $deliveryFee = $this->cart->deliveryFee($cart['subtotal']);
            return $this->view('checkout/index', [
                'items' => $cart['items'],
                'subtotal' => $cart['subtotal'],
                'deliveryFee' => $deliveryFee,
                'total' => $cart['subtotal'] + $deliveryFee,
                'singleStore' => $this->isSingleStore($cart['items']),
                'pickupEnabled' => OrderService::PICKUP_ENABLED,
                'old' => $data,
                'errors' => $result['errors'],
            ]);
        }

        $this->cart->clear();
        Response::redirect(url('checkout/success/' . $result['order']['order_number']));
    }

    public function success(string $orderNumber): mixed {
        $order = Order::findByOrderNumber($orderNumber);
        if (!$order) {
            http_response_code(404);
            return $this->view('errors/404');
        }

        return $this->view('checkout/success', [
            'order' => $order,
            'items' => OrderItem::byOrderId((int) $order['id']),
        ]);
    }

    /** Store Pickup only makes sense when every cart item comes from the same store. */
    private function isSingleStore(array $items): bool {
        return count(array_unique(array_column($items, 'store_id'))) <= 1;
    }
}
