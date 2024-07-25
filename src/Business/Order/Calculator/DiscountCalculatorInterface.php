<?php

namespace Src\Business\Order\Calculator;

interface DiscountCalculatorInterface
{
    /**
     * @param array<\Src\Business\Order\Shared\OrderDto> $orderList
     * @return array<\Src\Business\Order\Shared\OrderDto>
     */
    public function calculate(array $orderList): array;
}
