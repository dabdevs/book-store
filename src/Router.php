<?php 

namespace App;

class Router {
    protected $routes = [];

    private function addRoute($route, $controller, $action, $method, $middleware) 
    {
        $this->routes[$method][$route] = [
            'controller' => $controller, 
            'action' => $action,
            'middleware' => $middleware
        ];
    }

    public function get($route, $controller, $action, $middleware="")
    {
        $this->addRoute($route, $controller, $action, 'GET', $middleware);
    }

    public function post($route, $controller, $action, $middleware="")
    {
        $this->addRoute($route, $controller, $action, 'POST', $middleware);
    }

    public function put($route, $controller, $action, $middleware="")
    {
        $this->addRoute($route, $controller, $action, 'PUT', $middleware);
    }

    public function delete($route, $controller, $action, $middleware="")
    {
        $this->addRoute($route, $controller, $action, 'DELETE', $middleware);
    }

    public function dispatch()
    {
        $uri = strtok($_SERVER['REQUEST_URI'], '?');
        $method =  $_SERVER['REQUEST_METHOD'];

        try {
            if (array_key_exists($uri, $this->routes[$method])) {
                $controller = $this->routes[$method][$uri]['controller'];
                $action = $this->routes[$method][$uri]['action'];

                $controller = new $controller();
                $controller->$action();
            } else {
                header("Location:/not-found");
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}