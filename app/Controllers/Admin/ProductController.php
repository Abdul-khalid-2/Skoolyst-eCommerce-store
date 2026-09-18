<?php
declare(strict_types=1);

namespace Skoolyst\Controllers\Admin;

use Skoolyst\Core\Controller;
use Skoolyst\Core\Request;
use Skoolyst\Core\Response;
use Skoolyst\Models\Category;
use Skoolyst\Models\Store;
use Skoolyst\Services\ImageService;
use Skoolyst\Services\ProductService;

class ProductController extends Controller {
    private ProductService $products;
    private ImageService $images;

    public function __construct() {
        $this->products = new ProductService();
        $this->images = new ImageService();
    }

    public function index(): mixed {
        $filters = array_filter([
            'q' => trim((string) Request::input('q', '')),
            'status' => trim((string) Request::input('status', '')),
            'include_all_statuses' => true,
        ]);
        $page = (int) Request::input('page', 1);
        $perPage = (int) config('settings.pagination.admin_per_page', 15);

        return $this->view('admin/products/index', [
            'result' => $this->products->paginate($filters, $page, $perPage),
            'filters' => $filters,
        ]);
    }

    public function create(): mixed {
        return $this->view('admin/products/create', [
            'stores' => Store::all('name ASC'),
            'categories' => Category::all('name ASC'),
        ]);
    }

    public function store(): mixed {
        csrf_verify_or_abort();

        $upload = $this->images->upload($_FILES['image'] ?? [], config('settings.upload.products_dir'));
        $result = $this->products->create(Request::all(), $upload['path']);

        if ($result['errors'] || $upload['errors']) {
            return $this->view('admin/products/create', [
                'stores' => Store::all('name ASC'),
                'categories' => Category::all('name ASC'),
                'errors' => $result['errors'],
                'old' => Request::all(),
            ]);
        }

        flash('success', 'Product created successfully.');
        Response::redirect(url('admin/products'));
    }

    public function setStatus(string $id): never {
        csrf_verify_or_abort();
        $status = (string) Request::input('status', 'draft');
        $this->products->setStatus((int) $id, $status);
        flash('success', 'Product status updated.');
        Response::redirect(url('admin/products'));
    }

    public function destroy(string $id): never {
        csrf_verify_or_abort();
        $this->products->delete((int) $id);
        flash('success', 'Product deleted.');
        Response::redirect(url('admin/products'));
    }
}
