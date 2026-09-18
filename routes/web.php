<?php
// Public/frontend browser routes.

use Skoolyst\Controllers\Admin\CategoryController as AdminCategoryController;
use Skoolyst\Controllers\Admin\DashboardController as AdminDashboardController;
use Skoolyst\Controllers\Admin\ProductController as AdminProductController;
use Skoolyst\Controllers\Admin\StoreController as AdminStoreController;
use Skoolyst\Controllers\AuthController;
use Skoolyst\Controllers\CartController;
use Skoolyst\Controllers\CheckoutController;
use Skoolyst\Controllers\HomeController;
use Skoolyst\Controllers\ProductController;
use Skoolyst\Controllers\StoreController;
use Skoolyst\Middleware\AdminMiddleware;
use Skoolyst\Middleware\GuestMiddleware;

/** @var \Skoolyst\Core\Router $router */

// ---- Public storefront ----
$router->get('/', [HomeController::class, 'index']);

$router->get('/stores', [StoreController::class, 'index']);
$router->get('/stores/search', [StoreController::class, 'search']);
$router->get('/stores/{slug}', [StoreController::class, 'show']);

$router->get('/products', [ProductController::class, 'index']);
$router->get('/products/{slug}', [ProductController::class, 'show']);

$router->get('/cart', [CartController::class, 'index']);
$router->get('/checkout', [CheckoutController::class, 'index']);
$router->post('/checkout', [CheckoutController::class, 'store']);

// ---- Auth ----
$router->get('/login', [AuthController::class, 'loginForm'], [GuestMiddleware::class]);
$router->post('/login', [AuthController::class, 'login'], [GuestMiddleware::class]);
$router->get('/register', [AuthController::class, 'registerForm'], [GuestMiddleware::class]);
$router->post('/register', [AuthController::class, 'register'], [GuestMiddleware::class]);
$router->get('/logout', [AuthController::class, 'logout']);

// ---- Admin (platform admin managing the store directory) ----
$router->get('/admin/dashboard', [AdminDashboardController::class, 'index'], [AdminMiddleware::class]);

$router->get('/admin/stores', [AdminStoreController::class, 'index'], [AdminMiddleware::class]);
$router->get('/admin/stores/create', [AdminStoreController::class, 'create'], [AdminMiddleware::class]);
$router->post('/admin/stores', [AdminStoreController::class, 'store'], [AdminMiddleware::class]);
$router->get('/admin/stores/{id}', [AdminStoreController::class, 'show'], [AdminMiddleware::class]);
$router->get('/admin/stores/{id}/edit', [AdminStoreController::class, 'edit'], [AdminMiddleware::class]);
$router->post('/admin/stores/{id}/update', [AdminStoreController::class, 'update'], [AdminMiddleware::class]);
$router->post('/admin/stores/{id}/status', [AdminStoreController::class, 'setStatus'], [AdminMiddleware::class]);
$router->post('/admin/stores/{id}/delete', [AdminStoreController::class, 'destroy'], [AdminMiddleware::class]);

$router->get('/admin/products', [AdminProductController::class, 'index'], [AdminMiddleware::class]);
$router->get('/admin/products/create', [AdminProductController::class, 'create'], [AdminMiddleware::class]);
$router->post('/admin/products', [AdminProductController::class, 'store'], [AdminMiddleware::class]);
$router->post('/admin/products/{id}/status', [AdminProductController::class, 'setStatus'], [AdminMiddleware::class]);
$router->post('/admin/products/{id}/delete', [AdminProductController::class, 'destroy'], [AdminMiddleware::class]);

$router->get('/admin/categories', [AdminCategoryController::class, 'index'], [AdminMiddleware::class]);
$router->get('/admin/categories/create', [AdminCategoryController::class, 'create'], [AdminMiddleware::class]);
$router->post('/admin/categories', [AdminCategoryController::class, 'store'], [AdminMiddleware::class]);
$router->post('/admin/categories/{id}/delete', [AdminCategoryController::class, 'destroy'], [AdminMiddleware::class]);
