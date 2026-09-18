<?php
declare(strict_types=1);

namespace Skoolyst\Controllers;

use Skoolyst\Core\Controller;
use Skoolyst\Models\Product;
use Skoolyst\Models\Store;

/** robots.txt and XML sitemap for the public storefront. */
class SitemapController extends Controller {
    public function robots(): never {
        header('Content-Type: text/plain; charset=utf-8');
        echo <<<TXT
        User-agent: *
        Allow: /
        Disallow: /cart
        Disallow: /checkout
        Disallow: /favorites
        Disallow: /admin/
        Disallow: /store/dashboard
        Disallow: /store/create
        Disallow: /store/edit
        Disallow: /store/products
        Disallow: /login
        Disallow: /register

        Sitemap: {$this->sitemapUrl()}

        TXT;
        exit;
    }

    public function sitemap(): never {
        header('Content-Type: application/xml; charset=utf-8');

        $urls = [
            ['loc' => url(''), 'changefreq' => 'daily', 'priority' => '1.0'],
            ['loc' => url('stores'), 'changefreq' => 'daily', 'priority' => '0.9'],
            ['loc' => url('products'), 'changefreq' => 'daily', 'priority' => '0.9'],
            ['loc' => url('about'), 'changefreq' => 'monthly', 'priority' => '0.3'],
            ['loc' => url('contact'), 'changefreq' => 'monthly', 'priority' => '0.3'],
            ['loc' => url('privacy-policy'), 'changefreq' => 'yearly', 'priority' => '0.2'],
            ['loc' => url('terms'), 'changefreq' => 'yearly', 'priority' => '0.2'],
            ['loc' => url('returns-refunds'), 'changefreq' => 'yearly', 'priority' => '0.2'],
        ];

        foreach (Store::allActiveForSitemap() as $store) {
            $urls[] = [
                'loc' => url('stores/' . $store['slug']),
                'lastmod' => $this->toW3c($store['updated_at'] ?? null),
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ];
        }

        foreach (Product::allActiveForSitemap() as $product) {
            $urls[] = [
                'loc' => url('products/' . $product['slug']),
                'lastmod' => $this->toW3c($product['updated_at'] ?? null),
                'changefreq' => 'weekly',
                'priority' => '0.6',
            ];
        }

        echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        foreach ($urls as $url) {
            echo '  <url>' . "\n";
            echo '    <loc>' . htmlspecialchars($url['loc'], ENT_XML1 | ENT_QUOTES, 'UTF-8') . '</loc>' . "\n";
            if (!empty($url['lastmod'])) {
                echo '    <lastmod>' . $url['lastmod'] . '</lastmod>' . "\n";
            }
            echo '    <changefreq>' . $url['changefreq'] . '</changefreq>' . "\n";
            echo '    <priority>' . $url['priority'] . '</priority>' . "\n";
            echo '  </url>' . "\n";
        }
        echo '</urlset>';
        exit;
    }

    private function sitemapUrl(): string {
        return url('sitemap.xml');
    }

    private function toW3c(?string $datetime): ?string {
        if (!$datetime) {
            return null;
        }
        $timestamp = strtotime($datetime);
        return $timestamp === false ? null : date('c', $timestamp);
    }
}
