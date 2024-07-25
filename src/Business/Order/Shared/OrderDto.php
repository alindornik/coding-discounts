<?php

namespace Src\Business\Order\Shared;

use Src\Business\OrderItem\Shared\OrderItemDto;

class OrderDto
{
    public int $id;
    public int $customerId;
    public array $items = [];
    public float $total;
    public float $totalAfterDiscount;
    public float $customerDiscount;

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

    public function getCustomerDiscount(): float
    {
        return $this->customerDiscount;
    }

    public function setCustomerDiscount(float $customerDiscount): void
    {
        $this->customerDiscount = $customerDiscount;
    }

    public function getTotalAfterDiscount(): float
    {
        return $this->totalAfterDiscount;
    }

    public function setTotalAfterDiscount(float $totalAfterDiscount): void
    {
        $this->totalAfterDiscount = $totalAfterDiscount;
    }
}
