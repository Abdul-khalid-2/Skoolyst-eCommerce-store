<?php
declare(strict_types=1);

namespace Skoolyst\Middleware;

use Skoolyst\Core\Response;

// Protect authenticated web/API routes.
class AuthMiddleware {
    public function handle(): void {
        if (!is_authenticated()) {
            flash('error', 'Please log in to continue.');
            Response::redirect(url('login'));
        }
    }
}
