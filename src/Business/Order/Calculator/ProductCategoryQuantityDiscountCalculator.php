<?php

namespace Src\Business\Order\Calculator;

use Src\Business\Discount\Shared\DiscountDto;
use Src\Business\Discount\Shared\DiscountType;
use Src\Business\Order\Shared\DiscountOrderDto;
use Src\Business\Order\Shared\OrderDto;
use Src\Business\OrderItem\Shared\OrderItemDto;
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

    protected function calculateDiscount(OrderDto $order, DiscountDto $discountConfig): void
    {
        foreach ($order->getItems() as $item) {
            if ($this->isDiscountApplicableForItemCategory($item, $discountConfig) === false){
                continue;
            }

            $discountItemAmount = $item->getUnitPrice() * intdiv($item->getQuantity(), ($discountConfig->getBuyQuantity() + $discountConfig->getFreeQuantity()));
            if ($discountItemAmount == 0) {
                continue;
            }

            $orderDiscountDto = $this->getOrCreateDiscountOrderDto($order, DiscountType::PRODUCT_CATEGORY_QUANTITY);
            //this type of discounts adds up
            $orderDiscountDto->setValue($orderDiscountDto->getValue() + $discountItemAmount);
        }
    }

    protected function isDiscountApplicableForItemCategory(OrderItemDto $item, DiscountDto $discountConfig): bool
    {
        $product = $this->productFacade->getProductById($item->getProductId());
        return $product !== null && $product->getCategory() == $discountConfig->getCategoryId();
    }

    /**
     * @param \Src\Business\Order\Shared\OrderDto $order
     * @return \Src\Business\Order\Shared\DiscountOrderDto|null
     */
    protected function getOrCreateDiscountOrderDto(OrderDto $order, DiscountType $type): ?DiscountOrderDto
    {
        $orderDiscountDto = $order->findDiscountByType($type);
        if ($orderDiscountDto === null) {
            $orderDiscountDto = new DiscountOrderDto();
            $orderDiscountDto->setType($type);
            $order->addOrderDiscounts($orderDiscountDto);
        }

        return $orderDiscountDto;
    }
}
