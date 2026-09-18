<?php
declare(strict_types=1);

namespace Skoolyst\Controllers\Admin;

use Skoolyst\Core\Controller;
use Skoolyst\Services\ProductService;
use Skoolyst\Services\StoreService;

class DashboardController extends Controller {
    public function index(): mixed {
        $storeService = new StoreService();
        $productService = new ProductService();

        return $this->view('admin/dashboard/index', [
            'storeStats' => $storeService->stats(),
            'productStats' => $productService->stats(),
        ]);
    }
}
