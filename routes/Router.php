<?php

namespace Router;

class Router {

    public string $url;
    public array $routes = [];

    public function __construct($url) {
        $this->url = trim($url, '/');
    }
    
    public function get(string $path, string $action) {
        $this->routes['GET'][] = new Route($path, $action); 
    }

    public function post(string $path, string $action) {
        $this->routes['POST'][] = new Route($path, $action);
    }
    
    public function run() {
        $matchedRoute = false;

        foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
            if ($route->matches($this->url)) {
                $matchedRoute = true;
                $route->execute();
            }
        }
        if ($matchedRoute = false) {
            return header('HTTP/1.0 404 Not Found');
        }
    }

}
