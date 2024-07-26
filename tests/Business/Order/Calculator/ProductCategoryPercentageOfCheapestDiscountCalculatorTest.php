<?php

namespace Business\Order\Calculator;

use PHPUnit\Framework\TestCase;
use Src\Business\Discount\Shared\DiscountDto;
use Src\Business\Order\Calculator\ProductCategoryPercentageOfCheapestDiscountCalculator;
use Src\Business\Order\Shared\OrderDto;
use Src\Business\OrderItem\Shared\OrderItemDto;
use Src\Business\Product\ProductFacadeInterface;
use Src\Business\Product\Shared\ProductDto;

class ProductCategoryPercentageOfCheapestDiscountCalculatorTest extends TestCase
{
    public function testThatDiscountSumsUpWhenItemCategoryMatchTheConfiguredDiscounts()
    {
        // Arrange
        $order = $this->createOrderWithItems([
            ['productId' => '1a', 'quantity' => 2, 'unitPrice' => 5.0],
            ['productId' => '2a', 'quantity' => 3, 'unitPrice' => 2.0],
            ['productId' => 'b2', 'quantity' => 3, 'unitPrice' => 8.0]
        ]);

        $product1 = new ProductDto();
        $product1->setCategory(1);
        $product2 = new ProductDto();
        $product2->setCategory(2);

        $productFacade = $this->createMock(ProductFacadeInterface::class);
        $productFacade->method('getProductById')->willReturn($product1, $product1, $product2, $product1, $product1, $product2);

        $discountConfig1 = $this->createDiscountConfig(1, 5, 0.2, true);
        $discountConfig2 = $this->createDiscountConfig(2, 2, 0.1, true);
        $calculator = new ProductCategoryPercentageOfCheapestDiscountCalculator($productFacade, [$discountConfig1, $discountConfig2]);

        // Act
        $orderList = $calculator->calculate([$order]);

        // Assert
        $this->assertEquals(1.2, round($orderList[0]->getProductCategoryPercentageOfCheapestDiscount(), 2));
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

    private function createDiscountConfig(int $categoryId, int $minimumQuantity, float $percentage, bool $isActive): DiscountDto
    {
        $discountConfig = new DiscountDto();
        $discountConfig->setCategoryId($categoryId);
        $discountConfig->setMinimumQuantity($minimumQuantity);
        $discountConfig->setPercentage($percentage);
        $discountConfig->setActive($isActive);
        return $discountConfig;
    }

}
