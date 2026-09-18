<?php
declare(strict_types=1);

namespace Skoolyst\Services;

use Skoolyst\Models\Product;

/** Session-only favorites (no database record) — cleared when the session ends. */
class FavoriteService {
    private const SESSION_KEY = 'favorites';

    public function toggle(int $productId): bool {
        $favorites = $_SESSION[self::SESSION_KEY] ?? [];

        if (in_array($productId, $favorites, true)) {
            $_SESSION[self::SESSION_KEY] = array_values(array_diff($favorites, [$productId]));
            return false;
        }

        $favorites[] = $productId;
        $_SESSION[self::SESSION_KEY] = $favorites;
        return true;
    }

    public function ids(): array {
        return $_SESSION[self::SESSION_KEY] ?? [];
    }

    public function count(): int {
        return count($this->ids());
    }

    public function products(): array {
        $products = [];
        foreach ($this->ids() as $id) {
            $product = Product::findActiveById((int) $id);
            if ($product) {
                $products[] = $product;
            }
        }
        return $products;
    }
}
