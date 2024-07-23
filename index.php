<?php

require __DIR__ . '/vendor/autoload.php';

use Src\Api\Router;
use Src\OrdersDiscounts\Controller\OrderDiscountController;

$json = file_get_contents('php://input');
$body = json_decode($json, true);

$router = new Router();
$orderDiscountController = new OrderDiscountController();

$router->add('/v1/orders/discounts', function($body) use ($router, $orderDiscountController) {
    //todo: transform body to request object
    $response = $orderDiscountController->getDiscounts($body);
    $router->sendJsonResponse($response);
}, 'GET');


$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

$router->dispatch($requestUri, $requestMethod, $body);
