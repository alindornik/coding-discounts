<?php

namespace Src\Business\Order\Calculator;

use Src\Business\Customer\CustomerFacadeInterface;
use Src\Business\Customer\Shared\CustomerDto;
use Src\Business\Discount\Shared\DiscountDto;
use Src\Business\Discount\Shared\DiscountType;
use Src\Business\Order\Shared\DiscountOrderDto;
use Src\Business\Order\Shared\OrderDto;

class CustomerOrderOverLimitDiscountCalculator implements DiscountCalculatorInterface
{
    public function __construct(protected CustomerFacadeInterface $customerFacade, protected array $discountConfig)
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
            if ($customer === null) {
                continue;
            }

            foreach ($this->discountConfig as $discountConfig) {
                if ($discountConfig->isActive() === false) {
                    continue;
                }

                $this->calculateDiscount($customer, $discountConfig, $order);
            }
        }

        return $orderList;
    }

    private function calculateDiscount(CustomerDto $customer, DiscountDto $discountConfig, OrderDto $order): void
    {
        if ($customer->getRevenue() > $discountConfig->getLimit()) {
            //todo: replace round with some kind of rounding strategy to not lose precision
            $discountAmount = round($order->getTotal() * $discountConfig->getPercentage(), 2);

            //apply the highest discount
            $orderDiscountDto = $order->findDiscountByType(DiscountType::CUSTOMER_OVER_LIMIT);
            if ($orderDiscountDto === null) {
                $orderDiscountDto = new DiscountOrderDto();
                $orderDiscountDto->setType(DiscountType::CUSTOMER_OVER_LIMIT);
                $orderDiscountDto->setValue($discountAmount);
                $order->addOrderDiscounts($orderDiscountDto);
            }

            if ($discountAmount > $orderDiscountDto->getValue()) {
                $orderDiscountDto->setValue($discountAmount);
            }
        }
    }
}
