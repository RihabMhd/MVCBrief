<?php

namespace App\Routers;

class Router
{
    private array $routes = [];
    private $db;

    public function __construct($db = null)
    {
        $this->db = $db;
    }

    public function get(string $uri, string $action, array $middlewares = []): void
    {
        $this->addRoute('GET', $uri, $action, $middlewares);
    }

    public function post(string $uri, string $action, array $middlewares = []): void
    {
        $this->addRoute('POST', $uri, $action, $middlewares);
    }

    private function addRoute(string $method, string $uri, string $action, array $middlewares): void
    {
        $uri = '/' . trim($uri, '/');
        $this->routes[$method][$uri] = [
            'action' => $action,
            'middlewares' => $middlewares
        ];
    }

    public function dispatch(string $method, string $uri): void
    {
        $uri = parse_url($uri, PHP_URL_PATH);
        $uri = '/' . trim($uri, '/');

        if (!isset($this->routes[$method][$uri])) {
            $this->notFound();
            return;
        }

        $route = $this->routes[$method][$uri];

        $next = function () use ($route) {
            return $this->executeController($route['action']);
        };

        foreach (array_reverse($route['middlewares']) as $middleware) {
            $prev = $next;
            $next = function () use ($middleware, $prev) {
                return $middleware->handle($_REQUEST, $prev);
            };
        }

        $next();
    }

    private function executeController(string $action)
    {
        [$controller, $method] = explode('@', $action);
        $controllerClass = "App\\Controllers\\$controller";

        global $authService, $userService, $roleService, $validator;

        $instance = match ($controller) {
            'AuthController' => new $controllerClass($authService, $validator),
            'AdminController' => new $controllerClass($authService, $userService, $roleService),
            'RecruiterController', 'CandidateController' => new $controllerClass($authService),
            default => throw new \Exception("Unknown controller: $controller")
        };

        return $instance->$method();
    }

    private function notFound(): void
    {
        http_response_code(404);
        echo "404 Not Found";
    }
}

$db = \App\Config\Database::connect();
$router = new Router($db);

use App\Middleware\AuthMiddleware;
use App\Middleware\RoleMiddleware;

$auth = new AuthMiddleware();
$admin = new RoleMiddleware(['admin']);
$recruiter = new RoleMiddleware(['recruiter']);
$candidate = new RoleMiddleware(['candidate']);

$router->get('/', 'AuthController@showLoginForm');
$router->get('/login', 'AuthController@showLoginForm');
$router->post('/login', 'AuthController@login');
$router->get('/register', 'AuthController@showRegisterForm');
$router->post('/register', 'AuthController@register');

$router->get('/logout', 'AuthController@logout', [$auth]);
$router->post('/logout', 'AuthController@logout', [$auth]);
$router->get('/change-password', 'AuthController@showChangePasswordForm', [$auth]);
$router->post('/change-password', 'AuthController@changePassword', [$auth]);
$router->get('/dashboard', 'AuthController@dashboard', [$auth]);

$router->get('/admin/dashboard', 'AdminController@dashboard', [$auth, $admin]);
$router->get('/admin/users', 'AdminController@listUsers', [$auth, $admin]);
$router->get('/admin/roles', 'AdminController@listRoles', [$auth, $admin]);

$router->get('/recruiter/dashboard', 'RecruiterController@dashboard', [$auth, $recruiter]);

$router->get('/candidate/dashboard', 'CandidateController@dashboard', [$auth, $candidate]);

return $router;
