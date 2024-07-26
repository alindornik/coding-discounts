<?php

namespace Src\Business\OrderItem\Shared;

class OrderItemDto
{
    public string $productId;
    public int $quantity;
    public float $unitPrice;
    public float $total;

    public function setProductId(string $productId): void
    {
        $this->productId = $productId;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setUnitPrice(float $unitPrice): void
    {
        $this->unitPrice = $unitPrice;
    }

    public function getUnitPrice(): float
    {
        return $this->unitPrice;
    }

    public function setTotal(float $total): void
    {
        $this->total = $total;
    }

    public function getTotal(): float
    {
        return $this->total;
    }
}
