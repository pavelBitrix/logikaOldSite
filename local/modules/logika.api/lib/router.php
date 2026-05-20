<?php
namespace Logika\Api;

use Logika\Api\Auth\TokenAuth;
use Logika\Api\Controllers\LeadController;
use Logika\Api\Controllers\CatalogController;
use Logika\Api\Controllers\OrderController;

class Router
{
    private array $routes = [];

    public function __construct()
    {
        // Public routes (no auth)
        $this->register('POST', 'leads',          [LeadController::class, 'create']);

        // Protected routes
        $this->register('GET',  'catalog',          [CatalogController::class, 'index'],    true);
        $this->register('GET',  'catalog/filters',  [CatalogController::class, 'filters'],  true);
        $this->register('GET',  'catalog/sections', [CatalogController::class, 'sections'], true);
        $this->register('GET',  'catalog/{id}',     [CatalogController::class, 'show'],     true);
        $this->register('GET',  'orders',          [OrderController::class, 'index'],    true);
        $this->register('POST', 'orders',          [OrderController::class, 'create'],   true);
        $this->register('GET',  'orders/{id}',     [OrderController::class, 'show'],     true);
    }

    private function register(string $method, string $path, array $handler, bool $auth = false): void
    {
        $this->routes[] = compact('method', 'path', 'handler', 'auth');
    }

    public function dispatch(): void
    {
        $method  = $_SERVER['REQUEST_METHOD'];
        $uri     = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $uri     = preg_replace('#^api/?#', '', $uri);
        $params  = [];

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            $pattern = preg_replace('#\{(\w+)\}#', '(?P<$1>[^/]+)', $route['path']);
            if (!preg_match("#^$pattern$#", $uri, $matches)) {
                continue;
            }

            foreach ($matches as $k => $v) {
                if (!is_int($k)) {
                    $params[$k] = $v;
                }
            }

            if ($route['auth'] && !TokenAuth::check()) {
                Response::error('Unauthorized', 401);
                return;
            }

            $body = json_decode(file_get_contents('php://input'), true) ?? [];

            [$class, $action] = $route['handler'];
            $controller = new $class();
            $controller->$action($params, $body);
            return;
        }

        Response::error('Route not found', 404);
    }
}