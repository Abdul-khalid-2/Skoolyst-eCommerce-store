<?php
declare(strict_types=1);

namespace Skoolyst\Services;

use Skoolyst\Models\Product;

/** Session-backed shopping cart: $_SESSION['cart'] = [product_id => qty]. */
class CartService {
    private const SESSION_KEY = 'cart';
    public const FREE_DELIVERY_THRESHOLD = 3000.0;
    public const DELIVERY_FEE = 200.0;

    /** @return array{ok: bool, message: string} */
    public function add(int $productId, int $qty = 1): array {
        $product = Product::findActiveById($productId);
        if (!$product) {
            return ['ok' => false, 'message' => 'This product is not available.'];
        }
        if ((int) $product['stock'] <= 0) {
            return ['ok' => false, 'message' => 'This product is out of stock.'];
        }

        $qty = max(1, $qty);
        $cart = $_SESSION[self::SESSION_KEY] ?? [];
        $cart[$productId] = min((int) $product['stock'], ($cart[$productId] ?? 0) + $qty);
        $_SESSION[self::SESSION_KEY] = $cart;

        return ['ok' => true, 'message' => $product['name'] . ' added to cart.'];
    }

    public function update(int $productId, int $qty): void {
        $cart = $_SESSION[self::SESSION_KEY] ?? [];
        if (!array_key_exists($productId, $cart)) {
            return;
        }
        if ($qty <= 0) {
            unset($cart[$productId]);
        } else {
            $product = Product::findActiveById($productId);
            $max = $product ? max(1, (int) $product['stock']) : $qty;
            $cart[$productId] = min($qty, $max);
        }
        $_SESSION[self::SESSION_KEY] = $cart;
    }

    public function remove(int $productId): void {
        unset($_SESSION[self::SESSION_KEY][$productId]);
    }

    public function clear(): void {
        unset($_SESSION[self::SESSION_KEY]);
    }

    public function count(): int {
        return (int) array_sum($_SESSION[self::SESSION_KEY] ?? []);
    }

    /** @return array{items: list<array>, subtotal: float} */
    public function items(): array {
        $cart = $_SESSION[self::SESSION_KEY] ?? [];
        $items = [];
        $subtotal = 0.0;

        foreach ($cart as $productId => $qty) {
            $product = Product::findActiveById((int) $productId);
            if (!$product) {
                unset($_SESSION[self::SESSION_KEY][$productId]);
                continue;
            }

            $price = (float) ($product['sale_price'] ?: $product['price']);
            $qty = min((int) $qty, max(1, (int) $product['stock']));
            $lineTotal = $price * $qty;
            $subtotal += $lineTotal;

            $items[] = [
                'product_id' => (int) $product['id'],
                'name' => $product['name'],
                'slug' => $product['slug'],
                'image' => $product['image'],
                'store_id' => (int) $product['store_id'],
                'store_name' => $product['store_name'],
                'store_slug' => $product['store_slug'],
                'price' => $price,
                'qty' => $qty,
                'line_total' => $lineTotal,
            ];
        }

        return ['items' => $items, 'subtotal' => $subtotal];
    }

    public function deliveryFee(float $subtotal): float {
        if ($subtotal <= 0 || $subtotal >= self::FREE_DELIVERY_THRESHOLD) {
            return 0.0;
        }
        return self::DELIVERY_FEE;
    }
}
