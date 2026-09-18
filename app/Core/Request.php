<?php
declare(strict_types=1);

namespace Skoolyst\Core;

class Request {
    public static function method(): string { return strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET'); }
    public static function uri(): string {
        $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
        $base = rtrim((string) parse_url($_ENV['APP_URL'] ?? '', PHP_URL_PATH), '/');
        if ($base !== '' && stripos($path, $base) === 0) {
            $path = substr($path, strlen($base));
        }
        return $path === '' ? '/' : $path;
    }
    public static function input(string $key, mixed $default = null): mixed {
        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }
    public static function all(): array { return array_merge($_GET, $_POST); }
}
