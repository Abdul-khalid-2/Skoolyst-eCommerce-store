<?php
declare(strict_types=1);

namespace Skoolyst\Core;

class Router {
    /** @var array<string, list<array{regex:string, handler:callable|array, middleware:array}>> */
    private array $routes = [];

    public function get(string $path, callable|array $handler, array $middleware = []): void {
        $this->add('GET', $path, $handler, $middleware);
    }
    public function post(string $path, callable|array $handler, array $middleware = []): void {
        $this->add('POST', $path, $handler, $middleware);
    }
    public function put(string $path, callable|array $handler, array $middleware = []): void {
        $this->add('PUT', $path, $handler, $middleware);
    }
    public function delete(string $path, callable|array $handler, array $middleware = []): void {
        $this->add('DELETE', $path, $handler, $middleware);
    }

    private function add(string $method, string $path, callable|array $handler, array $middleware): void {
        $pattern = preg_replace('#\{([a-zA-Z_][a-zA-Z0-9_]*)\}#', '(?P<$1>[^/]+)', trim($path, '/'));
        $regex = '#^/' . $pattern . '$#';
        $this->routes[$method][] = ['regex' => $regex, 'handler' => $handler, 'middleware' => $middleware];
    }

    public function dispatch(string $method, string $uri): mixed {
        $path = $this->normalize($uri);

        foreach ($this->routes[$method] ?? [] as $route) {
            if (!preg_match($route['regex'], $path, $matches)) {
                continue;
            }

            $params = array_filter($matches, fn ($key) => !is_int($key), ARRAY_FILTER_USE_KEY);

            foreach ($route['middleware'] as $middleware) {
                (new $middleware())->handle();
            }

            $handler = $route['handler'];
            if (is_array($handler)) {
                [$class, $action] = $handler;
                return (new $class())->$action(...array_values($params));
            }
            return $handler(...array_values($params));
        }

        http_response_code(404);
        return View::render('errors/404');
    }

    private function normalize(string $path): string {
        $path = '/' . trim((string) (parse_url($path, PHP_URL_PATH) ?? '/'), '/');
        return $path;
    }
}
