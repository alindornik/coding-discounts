<?php

namespace Src\Business\Order;

class OrderConfig
{
    public const ORDER_DISCOUNT_CALCULATORS = [
        'CustomerOrderOverLimitDiscountCalculator',
        'ProductCategoryQuantityDiscountCalculator',
        'ProductCategoryPercentageOfCheapestDiscountCalculator'
    ];
}
