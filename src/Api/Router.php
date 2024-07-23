<?php

namespace Src\Api;
class Router {
    protected $routes = [];

    public function add($path, $action, $requestMethod) {
        $this->routes[] = new Route($path, $action, $requestMethod);
    }

    public function dispatch($requestUri, $requestMethod, $body = []) {
        foreach ($this->routes as $route) {
            if ($requestUri == $route->path && $requestMethod == $route->requestMethod) {
                call_user_func($route->action, $body);
                return;
            }
        }

        $this->handleNotFound();
    }

    public function sendJsonResponse($data, $statusCode = 200) {
        http_response_code($statusCode);
        echo json_encode($data);
    }

    protected function handleNotFound() {
        http_response_code(404);
        echo "404 Not Found";
    }
}
