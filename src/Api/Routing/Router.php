<?php

namespace Src\Api\Routing;

use Src\Api\Http\Request;
use Src\Api\Http\Response;

class Router {
    protected $routes = [];

    public function add($path, $action, $requestMethod) {
        $this->routes[] = new Route($path, $action, $requestMethod);
    }

    public function dispatch(Request $request) {
        foreach ($this->routes as $route) {
            if ($request->getUri() == $route->path && $request->getMethod() == $route->requestMethod) {
                call_user_func($route->action, $request);
                return;
            }
        }

        //todo extend to handle 404 and 405(method not allowed), for now just 404
        $this->sendJsonResponse(new Response(404, json_encode(['error' => 'Not Found'])));
    }

    public function sendJsonResponse(Response $response) {
        http_response_code($response->getStatusCode());
        header('Content-Type: application/json');
        echo $response->getBody();
    }
}
