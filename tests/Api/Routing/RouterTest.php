<?php

namespace Api\Routing;

use PHPUnit\Framework\TestCase;
use Src\Api\Http\Request;
use Src\Api\Http\Response;
use Src\Api\Routing\Router;

class RouterTest extends TestCase
{
    private Router $router;

    protected function setUp(): void
    {
        $this->router = new Router();
    }

    public function testDispatchValidRoute()
    {
        // Arrange
        $path = '/test';
        $requestMethod = 'GET';
        $request = $this->createMock(Request::class);
        $request->method('getUri')->willReturn($path);
        $request->method('getMethod')->willReturn($requestMethod);

        $expectedResponse = new Response(200, json_encode(['success' => true]));
        $action = function() use ($expectedResponse) {
            $this->router->sendJsonResponse($expectedResponse);
        };

        $this->router->add($path, $action, $requestMethod);

        // Act
        ob_start();
        $this->router->dispatch($request);
        $output = ob_get_clean();

        // Assert
        $this->assertJsonStringEqualsJsonString($expectedResponse->getBody(), $output);
    }

    public function testDispatchInvalidRoute()
    {
        // Arrange
        $path = '/invalid';
        $requestMethod = 'GET';
        $request = $this->createMock(Request::class);
        $request->method('getUri')->willReturn($path);
        $request->method('getMethod')->willReturn($requestMethod);

        $expectedResponse = new Response(404, json_encode(['error' => 'Not Found']));

        // Act
        ob_start();
        $this->router->dispatch($request);
        $output = ob_get_clean();

        // Assert
        $this->assertJsonStringEqualsJsonString($expectedResponse->getBody(), $output);
    }
}
