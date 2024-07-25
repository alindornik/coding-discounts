<?php

namespace Src\Business\Order;

use Src\Business\Order\Calculator\CustomerOrderOverLimitDiscountCalculator;

class OrderConfig
{
    public const ORDER_CALCULATORS = [
        'CustomerOrderOverLimitDiscountCalculator',
    ];

}
