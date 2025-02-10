<?php

namespace App\Core;

class Router
{
    protected $routes = [];

    public function add($method, $uri, $controller)
    {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller
        ];
    }
    public function dispatch()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            if ($route['method'] == $method && $route['uri'] == $uri) {
                return $this->callController($route['controller']);
            }
        }
        http_response_code(404);
        echo "404 Not Found";
    }
    protected function callController($controller) {
        [$class, $method] = explode('@', $controller);
        $class = "App\Controllers\\$class";
        (new $class())->$method();
    }
}
