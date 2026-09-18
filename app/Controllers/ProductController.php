<?php
declare(strict_types=1);

namespace Skoolyst\Controllers;

use Skoolyst\Core\Controller;
use Skoolyst\Core\Request;
use Skoolyst\Services\ProductService;

class ProductController extends Controller {
    private ProductService $products;

    public function __construct() {
        $this->products = new ProductService();
    }

    public function index(): mixed {
        $filters = array_filter([
            'q' => trim((string) Request::input('q', '')),
        ]);
        $page = (int) Request::input('page', 1);
        $perPage = (int) config('settings.pagination.products_per_page', 12);

        return $this->view('products/index', [
            'result' => $this->products->paginate($filters, $page, $perPage),
            'filters' => $filters,
        ]);
    }

    public function show(string $slug): mixed {
        $product = $this->products->findBySlugOrFail($slug);
        if (!$product) {
            http_response_code(404);
            return $this->view('errors/404');
        }

        return $this->view('products/show', ['product' => $product]);
    }
}
