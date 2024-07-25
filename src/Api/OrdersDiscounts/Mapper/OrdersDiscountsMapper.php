<?php

namespace Src\Api\OrdersDiscounts\Mapper;

use Src\Business\Order\Shared\OrderDto;
use Src\Business\OrderItem\Shared\OrderItemDto;

class OrdersDiscountsMapper
{
    /**
     * @param array $body
     * @return array<OrderDto>
     */
    public function mapBodyToOrderDto(array $body): array
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
