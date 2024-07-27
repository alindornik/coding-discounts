<?php

namespace Src\Business\Order\Shared;

use Src\Business\Discount\Shared\DiscountType;

class DiscountOrderDto
{
    public float $value = 0;
    public DiscountType $type;

    public function getValue(): float
    {
        return $this->value;
    }

    public function setValue(float $value): void
    {
        $this->value = $value;
    }

    public function getType(): DiscountType
    {
        return $this->type;
    }

    public function setType(DiscountType $type): void
    {
        $this->type = $type;
    }
}
