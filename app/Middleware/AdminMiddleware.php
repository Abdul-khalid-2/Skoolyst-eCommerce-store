<?php
declare(strict_types=1);

namespace Skoolyst\Middleware;

use Skoolyst\Core\Response;
use Skoolyst\Core\View;

// Protect administrator-only routes.
class AdminMiddleware {
    public function handle(): void {
        $user = auth_user();

        if (!$user) {
            flash('error', 'Please log in to continue.');
            Response::redirect(url('login'));
        }

        if (($user['role'] ?? null) !== 'admin') {
            http_response_code(403);
            View::render('errors/403');
            exit;
        }
    }
}
