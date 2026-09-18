<?php
declare(strict_types=1);

namespace Skoolyst\Controllers;

use Skoolyst\Core\Controller;
use Skoolyst\Core\Request;
use Skoolyst\Core\Response;
use Skoolyst\Services\CartService;

class CartController extends Controller {
    private CartService $cart;

    public function __construct() {
        $this->cart = new CartService();
    }

    public function index(): mixed {
        $cart = $this->cart->items();
        $deliveryFee = $this->cart->deliveryFee($cart['subtotal']);

        return $this->view('cart/index', [
            'items' => $cart['items'],
            'subtotal' => $cart['subtotal'],
            'deliveryFee' => $deliveryFee,
            'total' => $cart['subtotal'] + $deliveryFee,
        ]);
    }

    public function add(): never {
        csrf_verify_or_abort();

        $productId = (int) Request::input('product_id', 0);
        $qty = max(1, (int) Request::input('qty', 1));
        $result = $this->cart->add($productId, $qty);

        $this->json([
            'ok' => $result['ok'],
            'message' => $result['message'],
            'count' => $this->cart->count(),
        ]);
    }

    public function update(): never {
        csrf_verify_or_abort();

        $productId = (int) Request::input('product_id', 0);
        $qty = (int) Request::input('qty', 1);
        $this->cart->update($productId, $qty);

        Response::redirect(url('cart'));
    }

    public function remove(string $id): never {
        csrf_verify_or_abort();

        $this->cart->remove((int) $id);

        Response::redirect(url('cart'));
    }
}
