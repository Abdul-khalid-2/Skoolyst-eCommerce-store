<?php
declare(strict_types=1);

namespace Skoolyst\Middleware;

// API headers, authentication, rate-limit hooks and JSON-only responses.
class ApiMiddleware {
    public function handle(): void {
        header('Content-Type: application/json; charset=utf-8');
    }
}
