<?php

namespace Src\Business\Order\Calculator;

class OrdersDiscountsCalculator implements OrdersDiscountsCalculatorInterface
{

    public function __construct(protected array $discountCalculators)
    {
    }

    /**
     * @param array<\Src\Business\Order\Shared\OrderDto> $orderList
     * @return array<\Src\Business\Order\Shared\OrderDto>
     */
    public function calculate(array $orderList): array
    {
        foreach ($this->discountCalculators as $discountCalculator) {
            $orderList = $discountCalculator->calculate($orderList);
        }

        return $orderList;
    }
}
