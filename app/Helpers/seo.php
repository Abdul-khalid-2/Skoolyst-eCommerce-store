<?php
declare(strict_types=1);

/**
 * Meta-description helpers: keep everything within safe SERP display
 * lengths and fall back to a generated sentence when a store/product
 * hasn't written their own description.
 */

/** Truncates on a word boundary and never exceeds $limit characters. */
function seo_truncate(string $text, int $limit = 155): string
{
    $text = trim(preg_replace('/\s+/', ' ', $text) ?? '');
    if ($text === '' || mb_strlen($text) <= $limit) {
        return $text;
    }

    $cut = mb_substr($text, 0, $limit - 1);
    $lastSpace = mb_strrpos($cut, ' ');
    if ($lastSpace !== false && $lastSpace > 0) {
        $cut = mb_substr($cut, 0, $lastSpace);
    }

    return rtrim($cut, " ,.;:-") . '…';
}

/** @param array<string,mixed> $product Row shape from Product::findActiveBySlug()/findActiveById(). */
function product_meta_description(array $product): string
{
    $description = trim((string) ($product['description'] ?? ''));
    if ($description !== '') {
        return seo_truncate($description);
    }

    $price = (float) ($product['sale_price'] ?: $product['price'] ?? 0);
    $storeName = (string) ($product['store_name'] ?? 'Skoolyst Store');
    $name = (string) ($product['name'] ?? 'This product');

    return seo_truncate(sprintf(
        '%s available at %s on Skoolyst Store — Rs. %s. Browse more school essentials from trusted stores across Pakistan.',
        $name,
        $storeName,
        number_format($price)
    ));
}

/** @param array<string,mixed> $store Row shape from Store::findActiveBySlug(). */
function store_meta_description(array $store): string
{
    $description = trim((string) ($store['description'] ?? ''));
    if ($description !== '') {
        return seo_truncate($description);
    }

    $name = (string) ($store['name'] ?? 'This store');
    $city = trim((string) ($store['city'] ?? ''));
    $category = trim((string) ($store['category_name'] ?? ''));

    $parts = array_filter([$category !== '' ? $category : null, $city !== '' ? "in {$city}" : null]);
    $suffix = $parts ? ' ' . implode(' ', $parts) : '';

    return seo_truncate(sprintf(
        '%s%s on Skoolyst Store — browse products and get in touch directly with this trusted store.',
        $name,
        $suffix
    ));
}

/** Meta description for a category landing page (e.g. /stores/category/uniforms). */
function category_meta_description(string $categoryName, int $storeCount): string
{
    $countPhrase = $storeCount > 0
        ? sprintf('%d trusted %s', $storeCount, $storeCount === 1 ? 'store' : 'stores')
        : 'trusted stores';

    return seo_truncate(sprintf(
        'Browse %s selling %s on Skoolyst Store, Pakistan\'s education store directory. Compare stores and get in touch directly.',
        $countPhrase,
        mb_strtolower($categoryName)
    ));
}

/** Meta description for a city landing page (e.g. /stores/city/karachi). */
function city_meta_description(string $city, int $storeCount): string
{
    $countPhrase = $storeCount > 0
        ? sprintf('%d trusted %s', $storeCount, $storeCount === 1 ? 'store' : 'stores')
        : 'trusted stores';

    return seo_truncate(sprintf(
        'Find %s in %s selling school uniforms, shoes, bags, stationery and books on Skoolyst Store.',
        $countPhrase,
        $city
    ));
}
