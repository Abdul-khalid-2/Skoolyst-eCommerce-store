<?php
declare(strict_types=1);

namespace Skoolyst\Controllers;

use Skoolyst\Core\Controller;

class CheckoutController extends Controller {
    public function index(): mixed {
        return $this->view('frontend/checkout');
    }

    public function store(): mixed {
        // No order backend yet — prototype only, re-render the form.
        return $this->view('frontend/checkout');
    }
}
