<?php
declare(strict_types=1);

namespace Skoolyst\Controllers;

use Skoolyst\Core\Controller;

class CartController extends Controller {
    public function index(): mixed {
        return $this->view('frontend/cart');
    }
}
