<?php

namespace Src\Business\Order;

use Src\Business\Order\Calculator\OrdersDiscountsCalculatorInterface;

class OrderFacade implements OrderFacadeInterface
{
    public function __construct(protected OrdersDiscountsCalculatorInterface $ordersDiscountsCalculator)
    {
    }

    /**
     * @param array<\Src\Business\Order\Shared\OrderDto> $orderList
     * @return array<\Src\Business\Order\Shared\OrderDto>
     */
    public function calculateOrdersDiscounts(array $orderList): array
    {
        return $this->ordersDiscountsCalculator->calculate($orderList);
    }
}
