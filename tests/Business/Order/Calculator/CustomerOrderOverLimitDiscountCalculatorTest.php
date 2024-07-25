<?php

namespace Business\Order\Calculator;

use PHPUnit\Framework\TestCase;
use Src\Business\Customer\CustomerFacadeInterface;
use Src\Business\Customer\Shared\CustomerDto;
use Src\Business\Order\Calculator\CustomerOrderOverLimitDiscountCalculator;
use Src\Business\Order\Shared\OrderDto;

class CustomerOrderOverLimitDiscountCalculatorTest extends TestCase
{
    private CustomerFacadeInterface $customerFacade;
    private CustomerOrderOverLimitDiscountCalculator $calculator;

    protected function setUp(): void
    {
        $this->customerFacade = $this->createMock(CustomerFacadeInterface::class);
        $this->calculator = new CustomerOrderOverLimitDiscountCalculator($this->customerFacade);
    }

    public function testCalculateCustomerDiscountForCustomerRevenueAboveLimit()
    {
        // Arrange
        $customerId = 1;
        $order = new OrderDto();
        $order->setCustomerId($customerId);
        $order->setTotal(2000.0);

        $customer = $this->createMock(CustomerDto::class);
        $customer->method('getRevenue')->willReturn(1500.0);

        $this->customerFacade->method('getCustomerById')->with($customerId)->willReturn($customer);

        // Act
        $orderList = $this->calculator->calculate([$order]);

        // Assert
        $this->assertCount(1, $orderList);
        $resultOrder = $orderList[0];
        $this->assertEquals(200.0, $resultOrder->getCustomerDiscount());
        $this->assertEquals(1800.0, $resultOrder->getTotalAfterDiscount());
    }

    public function testCalculateCustomerDiscountForCustomerRevenueBelowLimit()
    {
        // Arrange
        $customerId = 1;
        $order = $this->createMock(OrderDto::class);
        $order->method('getCustomerId')->willReturn($customerId);
        $order->method('getTotal')->willReturn(2000.0);

        $customer = $this->createMock(CustomerDto::class);
        $customer->method('getRevenue')->willReturn(500.0);

        $this->customerFacade->method('getCustomerById')->with($customerId)->willReturn($customer);

        $order->expects($this->never())
            ->method('setCustomerDiscount');

        $order->expects($this->never())
            ->method('setTotalAfterDiscount');

        // Act
        $orderList = $this->calculator->calculate([$order]);

        // Assert
        $this->assertSame($orderList, [$order]);
    }
}
