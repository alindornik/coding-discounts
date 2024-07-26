<?php

namespace Src\Business\Order\Calculator;

use Src\Business\Discount\Shared\DiscountDto;
use Src\Business\Order\Shared\OrderDto;
use Src\Business\Product\ProductFacadeInterface;

class ProductCategoryQuantityDiscountCalculator implements DiscountCalculatorInterface
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
        foreach ($order->getItems() as $item) {
            //todo: cache product data to not query for each order item
            $product = $this->productFacade->getProductById($item->getProductId());
            if ($product === null || $product->getCategory() != $discountConfig->getCategoryId()) {
                continue;
            }

            $discountItemAmount = $item->getUnitPrice() * intdiv($item->getQuantity(), ($discountConfig->getBuyQuantity() + $discountConfig->getFreeQuantity()));
            //this type of discounts adds up
            $order->setProductCategoryQuantityDiscount($order->getProductCategoryQuantityDiscount() + $discountItemAmount);
        }
    }
}
