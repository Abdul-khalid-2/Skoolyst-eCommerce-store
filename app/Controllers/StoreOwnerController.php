<?php
declare(strict_types=1);

namespace Skoolyst\Controllers;

use Skoolyst\Core\Controller;
use Skoolyst\Core\Request;
use Skoolyst\Core\Response;
use Skoolyst\Models\Category;
use Skoolyst\Models\Product;
use Skoolyst\Models\Store;
use Skoolyst\Models\User;
use Skoolyst\Services\ImageService;
use Skoolyst\Services\ProductService;
use Skoolyst\Services\StoreService;

// Self-service "Open a Store" + store-owner dashboard. Scoped entirely to
// the logged-in user's own store — never trusts a store/product id from the
// client without checking it belongs to them first.
class StoreOwnerController extends Controller {
    private StoreService $stores;
    private ProductService $products;
    private ImageService $images;

    public function __construct() {
        $this->stores = new StoreService();
        $this->products = new ProductService();
        $this->images = new ImageService();
    }

    public function create(): mixed {
        if (is_store_admin()) {
            Response::redirect(url('store/dashboard'));
        }

        return $this->view('store-owner/create', [
            'categories' => Category::all('name ASC'),
        ]);
    }

    public function store(): mixed {
        csrf_verify_or_abort();

        if (is_store_admin()) {
            Response::redirect(url('store/dashboard'));
        }

        $upload = $this->images->upload($_FILES['logo'] ?? [], config('settings.upload.stores_dir'));
        $result = $this->stores->createForOwner(auth_id(), Request::all(), $upload['path']);

        if ($result['errors'] || $upload['errors']) {
            return $this->view('store-owner/create', [
                'categories' => Category::all('name ASC'),
                'errors' => $result['errors'],
                'old' => Request::all(),
            ]);
        }

        User::updateById(auth_id(), ['role' => 'store_admin']);
        $_SESSION['user']['role'] = 'store_admin';

        flash('success', 'Your store has been submitted and is pending approval.');
        Response::redirect(url('store/dashboard'));
    }

    public function dashboard(): mixed {
        $store = Store::findByUserId(auth_id());
        $products = $this->products->byStore((int) $store['id']);

        return $this->view('store-owner/dashboard', [
            'store' => $store,
            'products' => $products,
        ]);
    }

    public function edit(): mixed {
        $store = Store::findByUserId(auth_id());

        return $this->view('store-owner/edit', [
            'store' => $store,
            'categories' => Category::all('name ASC'),
        ]);
    }

    public function update(): mixed {
        csrf_verify_or_abort();

        $store = Store::findByUserId(auth_id());
        $upload = ['path' => null, 'errors' => []];
        if (!empty($_FILES['logo']['name'])) {
            $upload = $this->images->upload($_FILES['logo'], config('settings.upload.stores_dir'));
        }

        $errors = $this->stores->updateOwnStore((int) $store['id'], Request::all(), $upload['path']);

        if ($errors || $upload['errors']) {
            return $this->view('store-owner/edit', [
                'store' => $store,
                'categories' => Category::all('name ASC'),
                'errors' => $errors,
            ]);
        }

        if ($upload['path'] && $store['logo']) {
            $this->images->delete($store['logo']);
        }

        flash('success', 'Store details updated.');
        Response::redirect(url('store/dashboard'));
    }

    public function productsIndex(): mixed {
        $store = Store::findByUserId(auth_id());

        return $this->view('store-owner/products/index', [
            'store' => $store,
            'products' => $this->products->byStore((int) $store['id']),
        ]);
    }

    public function productCreate(): mixed {
        return $this->view('store-owner/products/create', [
            'categories' => Category::all('name ASC'),
        ]);
    }

    public function productStore(): mixed {
        csrf_verify_or_abort();

        $store = Store::findByUserId(auth_id());
        $upload = $this->images->upload($_FILES['image'] ?? [], config('settings.upload.products_dir'));
        $result = $this->products->createForStore((int) $store['id'], Request::all(), $upload['path']);

        if ($result['errors'] || $upload['errors']) {
            return $this->view('store-owner/products/create', [
                'categories' => Category::all('name ASC'),
                'errors' => $result['errors'],
                'old' => Request::all(),
            ]);
        }

        flash('success', 'Product added.');
        Response::redirect(url('store/products'));
    }

    public function productDestroy(string $id): never {
        csrf_verify_or_abort();

        $store = Store::findByUserId(auth_id());
        $product = Product::find((int) $id);

        if ($product && (int) $product['store_id'] === (int) $store['id']) {
            $this->products->delete((int) $id);
            flash('success', 'Product deleted.');
        }

        Response::redirect(url('store/products'));
    }
}
