<?php

namespace Src\Business\Order\Calculator;

use Src\Business\Discount\Shared\DiscountDto;
use Src\Business\Order\Shared\OrderDto;
use Src\Business\Product\ProductFacadeInterface;

class ProductCategoryPercentageOfCheapestDiscountCalculator implements DiscountCalculatorInterface
{
    public function __construct(protected ProductFacadeInterface $productFacade, protected array $discountConfig)
    {
    }

    /**
     * @param array<\Src\Business\Order\Shared\OrderDto> $orderList
     * @return array<\Src\Business\Order\Shared\OrderDto>
     */
    public function calculate(array $orderList): array
    {
        foreach ($orderList as $order) {
            /** @var \Src\Business\Discount\Shared\DiscountDto $discountConfig */
            foreach ($this->discountConfig as $discountConfig) {
                if ($discountConfig->isActive() === false) {
                    continue;
                }

                $this->calculateDiscount($order, $discountConfig);
            }
        }

        return $orderList;
    }

    private function calculateDiscount(OrderDto $order, DiscountDto $discountConfig): void
    {
        $cheapestItemUnitPrice = 0;
        $itemCategoryQuantity = 0;
        foreach ($order->getItems() as $item) {
            //todo: cache product data to not query for each order item
            $product = $this->productFacade->getProductById($item->getProductId());
            if ($product === null || $product->getCategory() != $discountConfig->getCategoryId()) {
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

        //todo: replace round with some kind of rounding strategy to not lose precision
        $discountAmount = round($cheapestItemUnitPrice * $discountConfig->getPercentage(), 2);
        //this type of discounts adds up
        $order->setProductCategoryPercentageOfCheapestDiscount(
            $order->getProductCategoryPercentageOfCheapestDiscount() + $discountAmount
        );
    }
}
