<?php

namespace Business\Order\Calculator;

use PHPUnit\Framework\TestCase;
use Src\Business\Order\Calculator\ProductCategoryQuantityDiscountCalculator;
use Src\Business\Order\Shared\OrderDto;
use Src\Business\OrderItem\Shared\OrderItemDto;
use Src\Business\Product\ProductFacadeInterface;
use Src\Business\Discount\Shared\DiscountDto;
use Src\Business\Product\Shared\ProductDto;

class ProductCategoryQuantityDiscountCalculatorTest extends TestCase
{
    public function testThatDiscountSumsUpWhenMultipleItemsMatchTheConfiguredDiscounts()
    {
        // Arrange
        $order = $this->createOrderWithItems([
            ['productId' => '1a', 'quantity' => 5, 'unitPrice' => 7.0],
            ['productId' => 'b2', 'quantity' => 3, 'unitPrice' => 4.0]
        ]);

        $product1 = new ProductDto();
        $product1->setCategory(1);
        $product2 = new ProductDto();
        $product2->setCategory(2);

        $productFacade = $this->createMock(ProductFacadeInterface::class);
        $productFacade->method('getProductById')->willReturn($product1, $product2, $product1, $product2);

        $discountConfig1 = $this->createDiscountConfig(1, 2, 1, true);
        $discountConfig2 = $this->createDiscountConfig(2, 2, 1, true);
        $calculator = new ProductCategoryQuantityDiscountCalculator($productFacade, [$discountConfig1, $discountConfig2]);

        // Act
        $orderList = $calculator->calculate([$order]);

        // Assert
        $this->assertEquals(11.0, $orderList[0]->getProductCategoryQuantityDiscount());
    }

    private function createOrderWithItems(array $items): OrderDto
    {
        $order = new OrderDto();
        foreach ($items as $itemData) {
            $item = new OrderItemDto();
            $item->setProductId($itemData['productId']);
            $item->setQuantity($itemData['quantity']);
            $item->setUnitPrice($itemData['unitPrice']);
            $order->addItem($item);
        }
        return $order;
    }

    private function createDiscountConfig(int $categoryId, int $buyQuantity, int $freeQuantity, bool $isActive): DiscountDto
    {
        $discountConfig = new DiscountDto();
        $discountConfig->setCategoryId($categoryId);
        $discountConfig->setBuyQuantity($buyQuantity);
        $discountConfig->setFreeQuantity($freeQuantity);
        $discountConfig->setActive($isActive);
        return $discountConfig;
    }
}
