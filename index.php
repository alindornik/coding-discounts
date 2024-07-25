<?php

require __DIR__ . '/vendor/autoload.php';
$container = require __DIR__ . '/src/Service/di-container-builder.php';

use Src\Api\Http\Request;
use Src\Api\OrdersDiscounts\Controller\OrdersDiscountsController;
use Src\Api\Routing\Router;

$json = file_get_contents('php://input');
$body = json_decode($json, true);

$request = new Request($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI'], $body);
$router = new Router();

/** @var OrdersDiscountsController $orderDiscountController */
$orderDiscountController = $container->get('OrdersDiscountsController');

//todo add swagger for documentation
$router->add('/v1/orders/discounts', function(Request $request) use ($router, $orderDiscountController) {
    $response = $orderDiscountController->getDiscounts($request->getBody());
    $router->sendJsonResponse($response);
}, 'GET');

$router->dispatch($request);
