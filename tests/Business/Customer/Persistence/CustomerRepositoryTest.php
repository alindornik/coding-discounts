<?php

namespace Business\Customer\Persistence;

use PHPUnit\Framework\TestCase;
use Src\Business\Customer\Persistence\CustomerRepository;
use Src\Business\Customer\Shared\CustomerDto;

class CustomerRepositoryTest extends TestCase
{
    private CustomerRepository $customerRepository;

    protected function setUp(): void
    {
        $this->customerRepository = new CustomerRepository();
    }

    public function testFindByIdCustomerIsFound()
    {
        // Arrange
        $id = 1;
        $expectedCustomer = new CustomerDto();
        $expectedCustomer->setId($id);
        $expectedCustomer->setName('Coca Cola');
        $expectedCustomer->setSince('2014-06-28');
        $expectedCustomer->setRevenue(492.12);

        // Act
        $customer = $this->customerRepository->findById($id);

        // Assert
        $this->assertNotNull($customer);
        $this->assertEquals($expectedCustomer->getId(), $customer->getId());
        $this->assertEquals($expectedCustomer->getName(), $customer->getName());
        $this->assertEquals($expectedCustomer->getSince(), $customer->getSince());
        $this->assertEquals($expectedCustomer->getRevenue(), $customer->getRevenue());
    }

    public function testFindByIdCustomerNotFound()
    {
        // Arrange
        $id = 999;

        // Act
        $customer = $this->customerRepository->findById($id);

        // Assert
        $this->assertNull($customer);
    }
}
