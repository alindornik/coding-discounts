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
    public float $customerOverLimitDiscount = 0;
    public float $productCategoryQuantityDiscount = 0;
    public float $productCategoryPercentageOfCheapestDiscount = 0;

    public function getProductCategoryPercentageOfCheapestDiscount(): float
    {
        return $this->productCategoryPercentageOfCheapestDiscount;
    }

    public function setProductCategoryPercentageOfCheapestDiscount(float $productCategoryPercentageOfCheapestDiscount): void
    {
        $this->productCategoryPercentageOfCheapestDiscount = $productCategoryPercentageOfCheapestDiscount;
    }

    public function getProductCategoryQuantityDiscount(): float
    {
        return $this->productCategoryQuantityDiscount;
    }

    public function setProductCategoryQuantityDiscount(float $productCategoryQuantityDiscount): void
    {
        $this->productCategoryQuantityDiscount = $productCategoryQuantityDiscount;
    }

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

    public function getCustomerOverLimitDiscount(): float
    {
        return $this->customerOverLimitDiscount;
    }

    public function setCustomerOverLimitDiscount(float $customerOverLimitDiscount): void
    {
        $this->customerOverLimitDiscount = $customerOverLimitDiscount;
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
