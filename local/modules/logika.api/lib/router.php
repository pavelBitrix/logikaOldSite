<?php
namespace Logika\Api;

use Logika\Api\Auth\TokenAuth;
use Logika\Api\Auth\UserAuth;
use Logika\Api\Controllers\AuthController;
use Logika\Api\Controllers\CartController;
use Logika\Api\Controllers\CatalogController;
use Logika\Api\Controllers\CheckoutController;
use Logika\Api\Controllers\LeadController;
use Logika\Api\Controllers\OrderController;
use Logika\Api\Controllers\UserController;
use Logika\Api\Controllers\WishlistController;

class Router
{
    private array $routes = [];

    public function __construct()
    {
        // ─── Auth (public) ───────────────────────────────────────────────────────
        $this->register('POST', 'auth/login',          [AuthController::class, 'login']);
        $this->register('POST', 'auth/logout',         [AuthController::class, 'logout']);
        $this->register('POST', 'auth/register',       [AuthController::class, 'register']);
        $this->register('POST', 'auth/password/reset', [AuthController::class, 'resetPassword']);

        // ─── Auth (user session required) ───────────────────────────────────────
        $this->register('GET',  'auth/me', [AuthController::class, 'me'], 'user');

        // ─── Catalog (public) ────────────────────────────────────────────────────
        $this->register('GET',  'catalog',                   [CatalogController::class, 'index']);
        $this->register('GET',  'catalog/sections',          [CatalogController::class, 'sections']);
        $this->register('GET',  'catalog/filters',           [CatalogController::class, 'filters']);
        $this->register('GET',  'catalog/compare',           [CatalogController::class, 'compare']);
        $this->register('GET',  'catalog/{id}',              [CatalogController::class, 'show']);
        $this->register('GET',  'catalog/{id}/reviews',      [CatalogController::class, 'reviews']);
        $this->register('POST', 'catalog/{id}/reviews',      [CatalogController::class, 'addReview']);

        // ─── Cart (user session required) ────────────────────────────────────────
        $this->register('GET',    'cart',            [CartController::class, 'index'],  'user');
        $this->register('POST',   'cart/add',        [CartController::class, 'add'],    'user');
        $this->register('PUT',    'cart/{itemId}',   [CartController::class, 'update'], 'user');
        $this->register('DELETE', 'cart/{itemId}',   [CartController::class, 'remove'], 'user');
        $this->register('DELETE', 'cart',            [CartController::class, 'clear'],  'user');

        // ─── Checkout ────────────────────────────────────────────────────────────
        $this->register('GET',  'checkout/info',      [CheckoutController::class, 'info']);
        $this->register('POST', 'checkout/calculate', [CheckoutController::class, 'calculate'],   'user');
        $this->register('POST', 'checkout/order',     [CheckoutController::class, 'createOrder'], 'user');

        // ─── Profile (user session required) ─────────────────────────────────────
        $this->register('GET',   'profile',              [UserController::class, 'profile'],      'user');
        $this->register('PATCH', 'profile',              [UserController::class, 'updateProfile'],'user');
        $this->register('GET',   'profile/orders',       [UserController::class, 'orders'],       'user');
        $this->register('GET',   'profile/orders/{id}',  [UserController::class, 'orderDetail'],  'user');

        // ─── Wishlist (user session required) ────────────────────────────────────
        $this->register('GET',    'wishlist',                      [WishlistController::class, 'index'],  'user');
        $this->register('POST',   'wishlist',                      [WishlistController::class, 'add'],    'user');
        $this->register('DELETE', 'wishlist/{productId}',          [WishlistController::class, 'remove'], 'user');
        $this->register('GET',    'wishlist/check/{productId}',    [WishlistController::class, 'check'],  'user');

        // ─── Leads (public) ──────────────────────────────────────────────────────
        $this->register('POST', 'leads', [LeadController::class, 'create']);

        // ─── Admin orders (token auth) ────────────────────────────────────────────
        $this->register('GET', 'orders',       [OrderController::class, 'index'], 'token');
        $this->register('GET', 'orders/{id}',  [OrderController::class, 'show'],  'token');
    }

    /**
     * @param string $auth  '' = public, 'user' = Bitrix session, 'token' = Bearer token
     */
    private function register(string $method, string $path, array $handler, string $auth = ''): void
    {
        $this->routes[] = compact('method', 'path', 'handler', 'auth');
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];

        // Support X-HTTP-Method-Override for clients that can't send PUT/PATCH/DELETE
        if ($method === 'POST' && !empty($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'])) {
            $method = strtoupper($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE']);
        }

        $uri    = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $uri    = preg_replace('#^(api/v\d+/|api/)#', '', $uri);
        $params = [];

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            $pattern = preg_replace('#\{(\w+)\}#', '(?P<$1>[^/]+)', $route['path']);
            if (!preg_match("#^{$pattern}$#", $uri, $matches)) {
                continue;
            }

            foreach ($matches as $k => $v) {
                if (!is_int($k)) {
                    $params[$k] = $v;
                }
            }

            // ─── Auth gate ───────────────────────────────────────────────────────
            switch ($route['auth']) {
                case 'token':
                    if (!TokenAuth::check()) {
                        Response::error('Unauthorized', 401);
                        return;
                    }
                    break;

                case 'user':
                    if (!UserAuth::check()) {
                        Response::error('Требуется авторизация', 401);
                        return;
                    }
                    break;
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
