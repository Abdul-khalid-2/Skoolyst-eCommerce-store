<?php
declare(strict_types=1);

namespace Skoolyst\Middleware;

use Skoolyst\Core\Response;

// Protects the "my store" self-service section: requires an authenticated
// user who has already opened a store (role = store_admin).
class StoreOwnerMiddleware {
    public function handle(): void {
        if (!is_authenticated()) {
            flash('error', 'Please log in to continue.');
            Response::redirect(url('login'));
        }

        if (!is_store_admin()) {
            Response::redirect(url('store/create'));
        }
    }
}
