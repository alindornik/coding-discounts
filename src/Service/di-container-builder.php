<?php

use DI\ContainerBuilder;
use Src\Api\OrdersDiscounts\Controller\OrdersDiscountsController;
use Src\Business\Customer\CustomerFacade;
use Src\Business\Customer\Persistence\CustomerRepository;
use Src\Business\Order\Calculator\CustomerOrderOverLimitDiscountCalculator;
use Src\Business\Order\Calculator\OrdersDiscountsCalculator;
use Src\Business\Order\OrderConfig;
use Src\Business\Order\OrderFacade;

function buildDiConfig(ContainerBuilder $containerBuilder) {
    return $containerBuilder->addDefinitions([
        'CustomerRepository' => \DI\autowire(CustomerRepository::class),
        'CustomerFacade' => \DI\autowire(CustomerFacade::class)
            ->constructor(customerRepository: \DI\get('CustomerRepository')),
        'CustomerOrderOverLimitDiscountCalculator' => \DI\autowire(CustomerOrderOverLimitDiscountCalculator::class)
            ->constructor(customerFacade: \DI\get('CustomerFacade')),
        'OrdersDiscountsController' => \DI\autowire(OrdersDiscountsController::class)
            ->constructor(ordersFacade: \DI\get('OrderFacade')),
        'OrderFacade' => \DI\autowire(OrderFacade::class)
            ->constructor(ordersDiscountsCalculator: \DI\get('OrdersDiscountsCalculator')),
        'OrdersDiscountsCalculator' => \DI\autowire(OrdersDiscountsCalculator::class)
            ->constructor(discountCalculators: buildOrderCalculatorList()),
    ]);
}

function buildOrderCalculatorList(): array
{
    $calculatorList = [];
    foreach (OrderConfig::ORDER_CALCULATORS as $calculator) {
        $calculatorList[] = \DI\get($calculator);
    }
    return $calculatorList;
}

$containerBuilder = new ContainerBuilder();
$containerBuilder->useAutowiring(true);
buildDiConfig($containerBuilder);

return $containerBuilder->build();
