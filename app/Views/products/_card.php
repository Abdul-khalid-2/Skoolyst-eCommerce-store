<?php
if (!function_exists('render_product_card')) {
    function render_product_card(array $product): string {
        $img = $product['image'] ?: 'https://images.pexels.com/photos/207580/pexels-photo-207580.jpeg?auto=compress&cs=tinysrgb&w=400';
        $price = '<span class="product-price">Rs. ' . number_format((float) $product['price']) . '</span>';
        if (!empty($product['sale_price'])) {
            $price = '<span class="product-price">Rs. ' . number_format((float) $product['sale_price']) . '</span> '
                . '<span class="product-old-price">Rs. ' . number_format((float) $product['price']) . '</span>';
        }
        $storeName = $product['store_name'] ?? '';
        $storeLink = isset($product['store_slug']) ? url('stores/' . $product['store_slug']) : url('stores');

        return '<div class="col-6 col-md-4 col-lg-3">'
            . '<div class="card card-hover product-card h-100">'
            . '<a href="' . url('products/' . $product['slug']) . '" class="text-decoration-none"><div class="product-img-wrap"><img src="' . clean($img) . '" alt="' . clean($product['name']) . '"></div></a>'
            . '<div class="card-body d-flex flex-column gap-1">'
            . '<a href="' . url('products/' . $product['slug']) . '" class="product-title text-decoration-none text-reset">' . clean($product['name']) . '</a>'
            . ($storeName ? '<a href="' . clean($storeLink) . '" class="store-name text-decoration-none"><i class="bi bi-shop"></i> ' . clean($storeName) . '</a>' : '')
            . '<div class="d-flex align-items-baseline gap-2 mt-1">' . $price . '</div>'
            . '</div></div></div>';
    }
}
