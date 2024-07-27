<?php

namespace Src\Business\Order\Calculator;

use Src\Business\Discount\Shared\DiscountDto;
use Src\Business\Discount\Shared\DiscountType;
use Src\Business\Order\Shared\OrderDto;

class ProductCategoryPercentageOfCheapestDiscountCalculator extends ProductCategoryQuantityDiscountCalculator implements DiscountCalculatorInterface
{
    protected function calculateDiscount(OrderDto $order, DiscountDto $discountConfig): void
    {
        $cheapestItemUnitPrice = 0;
        $itemCategoryQuantity = 0;
        foreach ($order->getItems() as $item) {
            if ($this->isDiscountApplicableForItemCategory($item, $discountConfig) === false){
                continue;
            }

            $itemCategoryQuantity += $item->getQuantity();
            if ($cheapestItemUnitPrice == 0 || $item->getUnitPrice() < $cheapestItemUnitPrice) {
                $cheapestItemUnitPrice = $item->getUnitPrice();
            }
        }

        if ($itemCategoryQuantity < $discountConfig->getMinimumQuantity()) {
            return;
        }

        $discountAmount = round($cheapestItemUnitPrice * $discountConfig->getPercentage(), 2);
        $orderDiscountDto = $this->getOrCreateDiscountOrderDto($order, DiscountType::PRODUCT_CATEGORY_PERCENTAGE_OF_CHEAPEST);
        //this type of discounts adds up
        $orderDiscountDto->setValue($orderDiscountDto->getValue() + $discountAmount);
    }
}
