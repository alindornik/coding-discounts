<?php

namespace OrdersDiscounts\Mapper;

use PHPUnit\Framework\TestCase;
use Src\OrdersDiscounts\Mapper\OrdersDiscountsMapper;
use Src\OrdersDiscounts\Shared\OrderDto;
use Src\OrdersDiscounts\Shared\OrderItemDto;

class OrdersDiscountsMapperTest extends TestCase
{
    private OrdersDiscountsMapper $mapper;

    protected function setUp(): void
    {
        $this->mapper = new OrdersDiscountsMapper();
    }

    public function testMapBodyToOrderDtoMultipleOrdersMultipleItems()
    {
        // Arrange
        $body = [
            'orders' => [
                [
                    'id' => 1,
                    'customer-id' => 1,
                    'items' => [
                        ['product-id' => 1, 'quantity' => 1, 'unit-price' => 100, 'total' => 100],
                        ['product-id' => 2, 'quantity' => 2, 'unit-price' => 50, 'total' => 100]
                    ],
                    'total' => 200
                ],
                [
                    'id' => 2,
                    'customer-id' => 2,
                    'items' => [
                        ['product-id' => 3, 'quantity' => 3, 'unit-price' => 30, 'total' => 90]
                    ],
                    'total' => 90
                ]
            ]
        ];

        // Act
        $orderList = $this->mapper->mapBodyToOrderDto($body);

        // Assert
        $this->assertCount(2, $orderList);

        $this->assertOrder($orderList[0], 1, 1, 200, [
            ['product-id' => 1, 'quantity' => 1, 'unit-price' => 100, 'total' => 100],
            ['product-id' => 2, 'quantity' => 2, 'unit-price' => 50, 'total' => 100]
        ]);

        $this->assertOrder($orderList[1], 2, 2, 90, [
            ['product-id' => 3, 'quantity' => 3, 'unit-price' => 30, 'total' => 90]
        ]);
    }

    private function assertOrder($order, $id, $customerId, $total, $items)
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

    private function assertItem($item, $expected)
    {
        $this->assertInstanceOf(OrderItemDto::class, $item);
        $this->assertEquals($expected['product-id'], $item->getProductId());
        $this->assertEquals($expected['quantity'], $item->getQuantity());
        $this->assertEquals($expected['unit-price'], $item->getUnitPrice());
        $this->assertEquals($expected['total'], $item->getTotal());
    }
}
