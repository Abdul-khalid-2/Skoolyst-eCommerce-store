<?php
declare(strict_types=1);

namespace Skoolyst\Middleware;

use Skoolyst\Core\Response;

// Restrict authenticated users from guest-only routes (login/register).
class GuestMiddleware {
    public function handle(): void {
        if (is_authenticated()) {
            Response::redirect(url(''));
        }
    }
}
