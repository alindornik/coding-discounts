<?php

namespace Api\OrdersDiscounts\Mapper;

use PHPUnit\Framework\TestCase;
use Src\Api\OrdersDiscounts\Mapper\OrdersDiscountsMapper;
use Src\Business\Order\Shared\OrderDto;
use Src\Business\OrderItem\Shared\OrderItemDto;

class OrdersDiscountsMapperTest extends TestCase
{
    private OrdersDiscountsMapper $mapper;

    protected function setUp(): void
    {
        $this->mapper = new OrdersDiscountsMapper();
    }

    public function testMapBodyToOrderDtoMultipleOrdersMultipleItems(): void
    {
        // Arrange
        $order1Items = [
            ['product-id' => 'A101', 'quantity' => 1, 'unit-price' => 100, 'total' => 100],
            ['product-id' => 'A102', 'quantity' => 2, 'unit-price' => 50, 'total' => 100]
        ];
        $order2Items = [
            ['product-id' => 'A103', 'quantity' => 3, 'unit-price' => 30, 'total' => 90]
        ];
        $body = [
            'orders' => [
                ['id' => 1, 'customer-id' => 1, 'items' => $order1Items, 'total' => 200],
                ['id' => 2, 'customer-id' => 2, 'items' => $order2Items, 'total' => 90]
            ]
        ];

        // Act
        $orderList = $this->mapper->mapBodyToOrderDto($body);

        // Assert
        $this->assertCount(2, $orderList);
        $this->assertOrder($orderList[0], 1, 1, 200, $order1Items);
        $this->assertOrder($orderList[1], 2, 2, 90, $order2Items);
    }

    private function assertOrder(OrderDto $order, int $id, int $customerId, float $total, array $items): void
    {
        $this->assertInstanceOf(OrderDto::class, $order);
        $this->assertEquals($id, $order->getId());
        $this->assertEquals($customerId, $order->getCustomerId());
        $this->assertEquals($total, $order->getTotal());

        $orderItems = $order->getItems();
        $this->assertCount(count($items), $orderItems);

        foreach ($items as $index => $item) {
            $this->assertItem($orderItems[$index], $item);
        }
    }

    private function assertItem(OrderItemDto $item, array $expected): void
    {
        $this->assertInstanceOf(OrderItemDto::class, $item);
        $this->assertEquals($expected['product-id'], $item->getProductId());
        $this->assertEquals($expected['quantity'], $item->getQuantity());
        $this->assertEquals($expected['unit-price'], $item->getUnitPrice());
        $this->assertEquals($expected['total'], $item->getTotal());
    }
}
