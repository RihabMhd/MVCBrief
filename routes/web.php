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
        $uri = trim($_SERVER['REQUEST_URI'], '/');

        foreach ($this->routes[$method] ?? [] as $route => $action) {

          
            $routeParts = explode('/', trim($route, '/'));
            $uriParts   = explode('/', $uri);

            if (count($routeParts) !== count($uriParts)) {
                continue;
            }

            $params = [];
            $match = true;

            foreach ($routeParts as $index => $part) {
                if (str_starts_with($part, '{')) {
                    $params[] = $uriParts[$index];
                } elseif ($part !== $uriParts[$index]) {
                    $match = false;
                    break;
                }
            }

            if ($match) {
                [$controller, $methodAction] = explode('@', $action);
                $controller = new $controller();

                return call_user_func_array(
                    [$controller, $methodAction],
                    $params
                );
            }
        }

      
        echo "404 Page not found";
    }
}
