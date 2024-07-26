<?php

namespace Src\Business\Order;

use Src\Business\Discount\Shared\DiscountDto;

class OrderConfig
{
    public const ORDER_DISCOUNT_CALCULATORS = [
        'CustomerOrderOverLimitDiscountCalculator',
        'ProductCategoryQuantityDiscountCalculator',
        'ProductCategoryPercentageOfCheapestDiscountCalculator'
    ];

    public static function getCustomerOverLimitDiscountConfig()
    {
        $discountConfig1 = new DiscountDto();
        $discountConfig1->setLimit(1000);
        $discountConfig1->setPercentage(0.1);
        $discountConfig1->setActive(true);

        return [
            $discountConfig1,
        ];
    }

    public static function getProductCatergoryQuantityDiscountConfig()
    {
        $discountConfig1 = new DiscountDto();
        $discountConfig1->setCategoryId(2);
        $discountConfig1->setBuyQuantity(5);
        $discountConfig1->setFreeQuantity(1);
        $discountConfig1->setActive(true);

        return [
            $discountConfig1,
        ];

    }

    public static function getProductCategoryPercentageOfCheapestDiscountConfig()
    {
        $discountConfig1 = new DiscountDto();
        $discountConfig1->setCategoryId(1);
        $discountConfig1->setPercentage(0.2);
        $discountConfig1->setMinimumQuantity(2);
        $discountConfig1->setActive(true);

        return [
            $discountConfig1,
        ];
    }
}
