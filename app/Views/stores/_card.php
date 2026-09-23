<?php
if (!function_exists('render_store_card')) {
    function render_store_card(array $store): string {
        $stars = '';
        $full = (int) round((float) $store['rating']);
        for ($i = 0; $i < 5; $i++) {
            $stars .= '<i class="bi bi-star' . ($i < $full ? '-fill' : '') . '"></i>';
        }

        $logo = media_url($store['logo'], 'https://images.pexels.com/photos/8364020/pexels-photo-8364020.jpeg?auto=compress&cs=tinysrgb&w=200');
        $verifiedBadge = $store['verified'] ? '<i class="bi bi-patch-check-fill verified-icon" title="Verified"></i>' : '';
        $typeLabel = $store['store_type'] === 'wholesale' ? 'Wholesale' : ($store['store_type'] === 'brand_outlet' ? 'Brand Outlet' : 'Retail');

        return '<div class="col-md-6 col-lg-4">'
            . '<div class="card card-hover store-card h-100"><div class="card-body d-flex flex-column gap-3">'
            . '<div class="d-flex gap-3 align-items-center">'
            . '<div class="store-logo-wrap"><img src="' . clean($logo) . '" alt="' . clean($store['name']) . ' logo"></div>'
            . '<div><h5 class="mb-0 fs-6">' . clean($store['name']) . ' ' . $verifiedBadge . '</h5>'
            . '<div class="small text-muted"><i class="bi bi-geo-alt"></i> ' . clean($store['city'] ?? '') . '</div>'
            . '<div class="stars mt-1" title="Skoolyst listing score, not a customer review">' . $stars . ' <span class="rating-num ms-1">' . number_format((float) $store['rating'], 1) . '</span> <span class="text-muted" style="font-size:.7em">Skoolyst Score</span></div>'
            . '</div></div>'
            . '<p class="small text-muted mb-0">' . clean(mb_strimwidth((string) $store['description'], 0, 100, '...')) . '</p>'
            . '<div class="d-flex justify-content-between align-items-center">'
            . skoolyst_badge($typeLabel, 'navy')
            . '<a href="' . url('stores/' . $store['slug']) . '" class="btn btn-sm btn-navy">View Store</a>'
            . '</div></div></div></div>';
    }
}
