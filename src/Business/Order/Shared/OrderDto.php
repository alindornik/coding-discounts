<?php

namespace Src\Business\Order\Shared;

use Src\Business\Discount\Shared\DiscountType;
use Src\Business\OrderItem\Shared\OrderItemDto;

class OrderDto
{
    public int $id;
    public int $customerId;
    public array $items = [];
    public float $total;
    public array $orderDiscounts = [];

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setCustomerId(int $customerId)
    {
        $this->customerId = $customerId;
    }

    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    public function addItem(OrderItemDto $item)
    {
        $this->items[] = $item;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function setTotal(float $total)
    {
        $this->total = $total;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function getOrderDiscounts(): array
    {
        return $this->orderDiscounts;
    }

    public function addOrderDiscounts(DiscountOrderDto $orderDiscount): void
    {
        $this->orderDiscounts[] = $orderDiscount;
    }

    public function findDiscountByType(DiscountType $type): ?DiscountOrderDto
    {
        $filtered_array = array_filter($this->getOrderDiscounts(), function ($obj) use ($type) {
            return $obj->getType() == $type;
        });

        return reset($filtered_array) ?: null;
    }
}
