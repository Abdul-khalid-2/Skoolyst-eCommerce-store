<?php
// Versionable JSON API routes — read-only for the store directory. All logic
// is delegated to the same Services the web controllers use.

use Skoolyst\Middleware\ApiMiddleware;
use Skoolyst\Models\Category;
use Skoolyst\Services\ProductService;
use Skoolyst\Services\StoreService;

/** @var \Skoolyst\Core\Router $router */

$router->get('/api/v1/stores', function () {
    $service = new StoreService();
    $page = (int) \Skoolyst\Core\Request::input('page', 1);
    $result = $service->paginate([], $page, 20);
    \Skoolyst\Core\Response::json([
        'data' => $result['rows'],
        'meta' => ['page' => $result['page'], 'total' => $result['total'], 'total_pages' => $result['totalPages']],
    ]);
}, [ApiMiddleware::class]);

$router->get('/api/v1/stores/{id}', function (string $id) {
    $store = \Skoolyst\Models\Store::find((int) $id);
    if (!$store) {
        \Skoolyst\Core\Response::json(['message' => 'Store not found'], 404);
    }
    \Skoolyst\Core\Response::json(['data' => $store]);
}, [ApiMiddleware::class]);

$router->get('/api/v1/categories', function () {
    \Skoolyst\Core\Response::json(['data' => Category::withStoreCounts()]);
}, [ApiMiddleware::class]);

$router->get('/api/v1/products', function () {
    $service = new ProductService();
    $page = (int) \Skoolyst\Core\Request::input('page', 1);
    $result = $service->paginate([], $page, 20);
    \Skoolyst\Core\Response::json([
        'data' => $result['rows'],
        'meta' => ['page' => $result['page'], 'total' => $result['total'], 'total_pages' => $result['totalPages']],
    ]);
}, [ApiMiddleware::class]);
