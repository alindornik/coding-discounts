<?php

namespace Src\OrdersDiscounts\Mapper;

use Src\OrdersDiscounts\Shared\OrderDto;
use Src\OrdersDiscounts\Shared\OrderItemDto;

class OrdersDiscountsMapper
{
    public function mapBodyToOrderDto(array $body)
    {
        $orderList = [];
        foreach ($body['orders'] as $orderData) {
            $orderDto = $this->createOrderDto($orderData);
            foreach ($orderData['items'] as $itemData) {
                $orderItemDto = $this->createOrderItemDto($itemData);
                $orderDto->addItem($orderItemDto);
            }
            $orderList[] = $orderDto;
        }

        return $orderList;
    }

    protected function createOrderDto(array $orderData): OrderDto
    {
        $orderDto = new OrderDto();
        $orderDto->setId($orderData['id']);
        $orderDto->setCustomerId($orderData['customer-id']);
        $orderDto->setTotal($orderData['total']);

        return $orderDto;
    }

    protected function createOrderItemDto(array $itemData): OrderItemDto
    {
        $orderItemDto = new OrderItemDto();
        $orderItemDto->setProductId($itemData['product-id']);
        $orderItemDto->setQuantity($itemData['quantity']);
        $orderItemDto->setUnitPrice($itemData['unit-price']);
        $orderItemDto->setTotal($itemData['total']);

        return $orderItemDto;
    }
}
