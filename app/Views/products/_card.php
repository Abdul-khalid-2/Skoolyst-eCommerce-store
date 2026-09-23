<?php
if (!function_exists('render_product_card')) {
    function render_product_card(array $product): string {
        $img = media_url($product['image'], 'https://images.pexels.com/photos/207580/pexels-photo-207580.jpeg?auto=compress&cs=tinysrgb&w=400');
        $price = '<span class="product-price">Rs. ' . number_format((float) $product['price']) . '</span>';
        if (!empty($product['sale_price'])) {
            $price = '<span class="product-price">Rs. ' . number_format((float) $product['sale_price']) . '</span> '
                . '<span class="product-old-price">Rs. ' . number_format((float) $product['price']) . '</span>';
        }
        $storeName = $product['store_name'] ?? '';
        $storeLink = isset($product['store_slug']) ? url('stores/' . $product['store_slug']) : url('stores');
        $id = (int) $product['id'];
        $inStock = (int) $product['stock'] > 0;
        $isFav = is_favorited($id);

        return '<div class="col-6 col-md-4 col-lg-3">'
            . '<div class="card card-hover product-card h-100">'
            . '<a href="' . url('products/' . $product['slug']) . '" class="text-decoration-none"><div class="product-img-wrap"><img src="' . clean($img) . '" alt="' . clean($product['name']) . '"></div></a>'
            . '<button type="button" class="btn btn-sm favorite-toggle-btn' . ($isFav ? ' active' : '') . '" data-favorite-toggle data-id="' . $id . '" aria-label="' . ($isFav ? 'Remove from favorites' : 'Add to favorites') . '"><i class="bi bi-heart' . ($isFav ? '-fill' : '') . '"></i></button>'
            . '<div class="card-body d-flex flex-column gap-1">'
            . '<a href="' . url('products/' . $product['slug']) . '" class="product-title text-decoration-none text-reset">' . clean($product['name']) . '</a>'
            . ($storeName ? '<a href="' . clean($storeLink) . '" class="store-name text-decoration-none"><i class="bi bi-shop"></i> ' . clean($storeName) . '</a>' : '')
            . '<div class="d-flex align-items-baseline gap-2 mt-1">' . $price . '</div>'
            . '<button type="button" class="btn btn-sm btn-navy mt-2" data-add-cart data-id="' . $id . '" ' . ($inStock ? '' : 'disabled') . '><i class="bi bi-cart-plus me-1"></i>' . ($inStock ? 'Add to Cart' : 'Out of Stock') . '</button>'
            . '</div></div></div>';
    }
}
