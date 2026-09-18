<?php
declare(strict_types=1);

/** Session-backed cart/favorites readers shared by view templates. */

function cart_count(): int {
    return (int) array_sum($_SESSION['cart'] ?? []);
}

function is_favorited(int $productId): bool {
    return in_array($productId, $_SESSION['favorites'] ?? [], true);
}

function favorites_count(): int {
    return count($_SESSION['favorites'] ?? []);
}
