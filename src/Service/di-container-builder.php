<?php

use DI\ContainerBuilder;
use Src\OrdersDiscounts\Controller\OrdersDiscountsController;

function buildDiConfig(ContainerBuilder $containerBuilder) {
    return $containerBuilder->addDefinitions([
        'OrderDiscountController' => \DI\autowire(OrdersDiscountsController::class),
    ]);
};

$containerBuilder = new ContainerBuilder();
buildDiConfig($containerBuilder);

return $containerBuilder->build();
