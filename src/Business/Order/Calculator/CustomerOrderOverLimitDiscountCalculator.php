<?php

namespace Src\Business\Order\Calculator;

use Src\Business\Customer\CustomerFacadeInterface;

class CustomerOrderOverLimitDiscountCalculator implements DiscountCalculatorInterface
{
    protected const REVENUE_LIMIT = 1000;
    protected const DISCOUNT = 0.1;

    public function __construct(protected CustomerFacadeInterface $customerFacade)
    {
    }

    /**
     * @param array<\Src\Business\Order\Shared\OrderDto> $orderList
     * @return array<\Src\Business\Order\Shared\OrderDto>
     */
    public function calculate(array $orderList): array
    {
        foreach ($orderList as $order) {
            //todo: cache customer data to not query for each order
            $customer = $this->customerFacade->getCustomerById($order->getCustomerId());
            if ($customer->getRevenue() > self::REVENUE_LIMIT) {
                //todo: replace round with some kind of rounding strategy to not lose precision
                $order->setCustomerDiscount(round($order->getTotal() * self::DISCOUNT, 2));
                $order->setTotalAfterDiscount($order->getTotal() - $order->getCustomerDiscount());
            }
        }

        return $orderList;
    }
}
