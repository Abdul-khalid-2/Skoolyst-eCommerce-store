<?php
declare(strict_types=1);

namespace Skoolyst\Controllers\Admin;

use Skoolyst\Core\Controller;
use Skoolyst\Core\Request;
use Skoolyst\Core\Response;
use Skoolyst\Models\Category;
use Skoolyst\Models\Store;
use Skoolyst\Services\ImageService;
use Skoolyst\Services\StoreService;

class StoreController extends Controller {
    private StoreService $stores;
    private ImageService $images;

    public function __construct() {
        $this->stores = new StoreService();
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

        return $this->view('admin/stores/index', [
            'result' => $this->stores->paginate($filters, $page, $perPage),
            'filters' => $filters,
        ]);
    }

    public function create(): mixed {
        return $this->view('admin/stores/create', [
            'categories' => Category::all('name ASC'),
        ]);
    }

    public function store(): mixed {
        csrf_verify_or_abort();

        $upload = $this->images->upload($_FILES['logo'] ?? [], config('settings.upload.stores_dir'));
        $result = $this->stores->create(Request::all(), $upload['path']);

        if ($result['errors'] || $upload['errors']) {
            flash('errors', array_merge($result['errors'], ['logo' => implode(' ', $upload['errors'])]));
            return $this->view('admin/stores/create', [
                'categories' => Category::all('name ASC'),
                'errors' => $result['errors'],
                'old' => Request::all(),
            ]);
        }

        flash('success', 'Store created successfully.');
        Response::redirect(url('admin/stores'));
    }

    public function edit(string $id): mixed {
        $store = Store::find((int) $id);
        if (!$store) {
            http_response_code(404);
            return $this->view('errors/404');
        }

        return $this->view('admin/stores/edit', [
            'store' => $store,
            'categories' => Category::all('name ASC'),
        ]);
    }

    public function update(string $id): mixed {
        csrf_verify_or_abort();

        $store = Store::find((int) $id);
        if (!$store) {
            http_response_code(404);
            return $this->view('errors/404');
        }

        $upload = ['path' => null, 'errors' => []];
        if (!empty($_FILES['logo']['name'])) {
            $upload = $this->images->upload($_FILES['logo'], config('settings.upload.stores_dir'));
        }

        $errors = $this->stores->update((int) $id, Request::all(), $upload['path']);

        if ($errors || $upload['errors']) {
            return $this->view('admin/stores/edit', [
                'store' => $store,
                'categories' => Category::all('name ASC'),
                'errors' => $errors,
            ]);
        }

        if ($upload['path'] && $store['logo']) {
            $this->images->delete($store['logo']);
        }

        flash('success', 'Store updated successfully.');
        Response::redirect(url('admin/stores'));
    }

    public function show(string $id): mixed {
        $store = Store::find((int) $id);
        if (!$store) {
            http_response_code(404);
            return $this->view('errors/404');
        }

        $productService = new \Skoolyst\Services\ProductService();

        return $this->view('admin/stores/show', [
            'store' => $store,
            'products' => $productService->byStore((int) $id),
        ]);
    }

    public function setStatus(string $id): never {
        csrf_verify_or_abort();
        $status = (string) Request::input('status', 'pending');
        $this->stores->setStatus((int) $id, $status);
        flash('success', 'Store status updated.');
        Response::redirect(url('admin/stores'));
    }

    public function destroy(string $id): never {
        csrf_verify_or_abort();
        $store = Store::find((int) $id);
        if ($store && $store['logo']) {
            $this->images->delete($store['logo']);
        }
        $this->stores->delete((int) $id);
        flash('success', 'Store deleted.');
        Response::redirect(url('admin/stores'));
    }
}
