<?php

namespace Src\Business\Order;

interface OrderFacadeInterface
{
    /**
     * @param array<\Src\Business\Order\Shared\OrderDto> $orderList
     * @return array<\Src\Business\Order\Shared\OrderDto>
     */
    public function calculateOrdersDiscounts(array $orderList): array;
}
