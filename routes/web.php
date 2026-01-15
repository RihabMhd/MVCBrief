<?php

class Router
{
    private array $routes = [];

    public function get(string $url, string $action)
    {
        $this->routes['GET'][$url] = $action;
    }

    public function post(string $url, string $action)
    {
        $this->routes['POST'][$url] = $action;
    }

    public function run()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $uri = trim($uri, '/');

        // Exact match
        if (isset($this->routes[$method][$uri])) {
            return $this->dispatch($this->routes[$method][$uri]);
        }

        // Dynamic routes
        foreach ($this->routes[$method] ?? [] as $route => $action) {
            $routeParts = explode('/', trim($route, '/'));
            $uriParts = explode('/', $uri);

            if (count($routeParts) !== count($uriParts)) {
                continue;
            }

            $params = [];
            $match = true;

            foreach ($routeParts as $index => $part) {
                if (str_starts_with($part, '{') && str_ends_with($part, '}')) {
                    $params[] = $uriParts[$index];
                } elseif ($part !== $uriParts[$index]) {
                    $match = false;
                    break;
                }
            }

            if ($match) {
                return $this->dispatch($action, $params);
            }
        }

        http_response_code(404);
        echo "404 - Page not found";
    }

    private function dispatch(string $action, array $params = [])
    {
        [$controllerName, $method] = explode('@', $action);

        // Get dependencies
        global $authService, $userService, $roleService, $validator;

        // Instantiate controller with dependencies
        $controller = match ($controllerName) {
            'AuthController' => new AuthController($authService, $validator),
            'AdminController' => new AdminController($authService, $userService, $roleService),
            'RecruiterController' => new RecruiterController($authService),
            'CandidateController' => new CandidateController($authService),
            default => throw new Exception("Controller $controllerName not found")
        };

        return call_user_func_array([$controller, $method], $params);
    }
}

// Define routes
$router = new Router();

// Auth routes
$router->get('', 'AuthController@showLoginForm');
$router->get('login', 'AuthController@showLoginForm');
$router->post('login', 'AuthController@login');
$router->get('register', 'AuthController@showRegisterForm');
$router->post('register', 'AuthController@register');
$router->get('logout', 'AuthController@logout');
$router->post('logout', 'AuthController@logout');
$router->get('change-password', 'AuthController@showChangePasswordForm');
$router->post('change-password', 'AuthController@changePassword');

// Admin routes
$router->get('admin/dashboard', 'AdminController@dashboard');
$router->get('admin/users', 'AdminController@listUsers');
$router->get('admin/roles', 'AdminController@listRoles');

// Recruiter routes
$router->get('recruiter/dashboard', 'RecruiterController@dashboard');

// Candidate routes
$router->get('candidate/dashboard', 'CandidateController@dashboard');

// Default dashboard route
$router->get('dashboard', 'AuthController@showLoginForm');

return $router;