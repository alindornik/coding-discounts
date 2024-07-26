<?php

namespace Src\Business\Discount\Shared;

class DiscountDto
{
    public int $limit;
    public float $percentage;
    public int $categoryId;
    public int $buyQuantity;
    public int $freeQuantity;
    public int $minimumQuantity;

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    public function setCategoryId(int $categoryId): void
    {
        $this->categoryId = $categoryId;
    }

    public function getBuyQuantity(): int
    {
        return $this->buyQuantity;
    }

    public function setBuyQuantity(int $buyQuantity): void
    {
        $this->buyQuantity = $buyQuantity;
    }

    public function getFreeQuantity(): int
    {
        return $this->freeQuantity;
    }

    public function setFreeQuantity(int $freeQuantity): void
    {
        $this->freeQuantity = $freeQuantity;
    }
    public bool $active;

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function setLimit(int $limit): void
    {
        $this->limit = $limit;
    }

    public function getPercentage(): float
    {
        return $this->percentage;
    }

    public function setPercentage(float $percentage): void
    {
        $this->percentage = $percentage;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    public function getMinimumQuantity(): int
    {
        return $this->minimumQuantity;
    }

    public function setMinimumQuantity(int $minimumQuantity): void
    {
        $this->minimumQuantity = $minimumQuantity;
    }
}
