<?php
declare(strict_types=1);

namespace Skoolyst\Controllers;

use Skoolyst\Core\Controller;
use Skoolyst\Core\Request;
use Skoolyst\Core\Response;
use Skoolyst\Models\Category;
use Skoolyst\Services\ReviewService;
use Skoolyst\Services\StoreService;

class StoreController extends Controller {
    private StoreService $stores;
    private ReviewService $reviews;

    public function __construct() {
        $this->stores = new StoreService();
        $this->reviews = new ReviewService();
    }

    public function index(): mixed {
        $filters = $this->filtersFromRequest();
        $page = (int) Request::input('page', 1);
        $perPage = (int) config('settings.pagination.stores_per_page', 9);

        return $this->view('stores/index', [
            'result' => $this->stores->paginate($filters, $page, $perPage),
            'categories' => Category::withStoreCounts(),
            'filters' => $filters,
        ]);
    }

    /** AJAX fragment: returns just the results grid + pagination for live filtering. */
    public function search(): mixed {
        $filters = $this->filtersFromRequest();
        $page = (int) Request::input('page', 1);
        $perPage = (int) config('settings.pagination.stores_per_page', 9);

        return $this->view('stores/search', [
            'result' => $this->stores->paginate($filters, $page, $perPage),
            'filters' => $filters,
        ]);
    }

    /** SEO landing page for a single category, e.g. /stores/category/uniforms. */
    public function category(string $slug): mixed {
        $category = Category::findBySlug($slug);
        if (!$category) {
            http_response_code(404);
            return $this->view('errors/404');
        }

        $filters = array_filter([
            'q' => trim((string) Request::input('q', '')),
            'category_id' => (int) $category['id'],
        ]);
        $page = (int) Request::input('page', 1);
        $perPage = (int) config('settings.pagination.stores_per_page', 9);
        $result = $this->stores->paginate($filters, $page, $perPage);

        return $this->view('stores/category', [
            'result' => $result,
            'category' => $category,
            'categories' => Category::withStoreCounts(),
            'cities' => $this->stores->cityCounts(),
            'filters' => $filters,
        ]);
    }

    /** SEO landing page for a single city, e.g. /stores/city/karachi. */
    public function city(string $slug): mixed {
        $city = $this->stores->findCityBySlug($slug);
        if (!$city) {
            http_response_code(404);
            return $this->view('errors/404');
        }

        $filters = array_filter([
            'q' => trim((string) Request::input('q', '')),
            'city' => $city['city'],
        ]);
        $page = (int) Request::input('page', 1);
        $perPage = (int) config('settings.pagination.stores_per_page', 9);
        $result = $this->stores->paginate($filters, $page, $perPage);

        return $this->view('stores/city', [
            'result' => $result,
            'city' => $city['city'],
            'cityStoreCount' => $city['store_count'],
            'categories' => Category::withStoreCounts(),
            'cities' => $this->stores->cityCounts(),
            'filters' => $filters,
        ]);
    }

    public function show(string $slug): mixed {
        $store = $this->stores->findBySlugOrFail($slug);
        if (!$store) {
            http_response_code(404);
            return $this->view('errors/404');
        }

        $productService = new \Skoolyst\Services\ProductService();

        return $this->view('stores/show', [
            'store' => $store,
            'products' => $productService->byStore((int) $store['id']),
            'reviews' => $this->reviews->byStore((int) $store['id']),
        ]);
    }

    /** Customer review submission. Always saved as pending — visible only after admin approval. */
    public function storeReview(string $slug): never {
        csrf_verify_or_abort();

        $store = $this->stores->findBySlugOrFail($slug);
        if (!$store) {
            http_response_code(404);
            Response::redirect(url('stores'));
        }

        $result = $this->reviews->create((int) $store['id'], (int) auth_user()['id'], Request::all());

        if ($result['errors']) {
            flash('errors', $result['errors']);
        } else {
            flash('success', 'Thanks for your review! It will appear once approved by our team.');
        }

        Response::redirect(url('stores/' . $slug));
    }

    private function filtersFromRequest(): array {
        return array_filter([
            'q' => trim((string) Request::input('q', '')),
            'city' => trim((string) Request::input('city', '')),
            'category_id' => (int) Request::input('category', 0) ?: null,
            'store_type' => trim((string) Request::input('type', '')),
            'verified_only' => Request::input('verified') === '1',
        ]);
    }
}
