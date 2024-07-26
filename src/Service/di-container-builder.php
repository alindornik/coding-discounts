<?php

use DI\ContainerBuilder;
use Src\Api\OrdersDiscounts\Controller\OrdersDiscountsController;
use Src\Business\Customer\CustomerFacade;
use Src\Business\Customer\Persistence\CustomerRepository;
use Src\Business\Order\Calculator\CustomerOrderOverLimitDiscountCalculator;
use Src\Business\Order\Calculator\OrdersDiscountsCalculator;
use Src\Business\Order\Calculator\ProductCategoryPercentageOfCheapestDiscountCalculator;
use Src\Business\Order\Calculator\ProductCategoryQuantityDiscountCalculator;
use Src\Business\Order\OrderConfig;
use Src\Business\Order\OrderFacade;
use Src\Business\Product\Persistence\ProductRepository;
use Src\Business\Product\ProductFacade;

function buildDiConfig(ContainerBuilder $containerBuilder) {
    return $containerBuilder->addDefinitions([
        'CustomerRepository' => \DI\autowire(CustomerRepository::class),
        'CustomerFacade' => \DI\autowire(CustomerFacade::class)
            ->constructor(customerRepository: \DI\get('CustomerRepository')),
        'ProductRepository' => \DI\autowire(ProductRepository::class),
        'ProductFacade' => \DI\autowire(ProductFacade::class)
            ->constructor(productRepository: \DI\get('ProductRepository')),

        'CustomerOrderOverLimitDiscountCalculator' => \DI\autowire(CustomerOrderOverLimitDiscountCalculator::class)
            ->constructor(customerFacade: \DI\get('CustomerFacade'), discountConfig: OrderConfig::getCustomerOverLimitDiscountConfig()),
        'ProductCategoryQuantityDiscountCalculator' => \DI\autowire(ProductCategoryQuantityDiscountCalculator::class)
            ->constructor(productFacade: \DI\get('ProductFacade'), discountConfig: OrderConfig::getProductCatergoryQuantityDiscountConfig()),
        'ProductCategoryPercentageOfCheapestDiscountCalculator' => \DI\autowire(ProductCategoryPercentageOfCheapestDiscountCalculator::class)
            ->constructor(productFacade: \DI\get('ProductFacade'), discountConfig: OrderConfig::getProductCategoryPercentageOfCheapestDiscountConfig()),

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
    foreach (OrderConfig::ORDER_DISCOUNT_CALCULATORS as $calculator) {
        $calculatorList[] = \DI\get($calculator);
    }
    return $calculatorList;
}

$containerBuilder = new ContainerBuilder();
$containerBuilder->useAutowiring(true);
buildDiConfig($containerBuilder);

return $containerBuilder->build();
