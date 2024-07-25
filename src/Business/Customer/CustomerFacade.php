<?php

namespace Src\Business\Customer;

use Src\Business\Customer\Persistence\CustomerRepositoryInterface;
use Src\Business\Customer\Shared\CustomerDto;

class CustomerFacade implements CustomerFacadeInterface
{
    public function __construct(protected CustomerRepositoryInterface $customerRepository)
    {
    }

    public function getCustomerById(int $customerId): ?CustomerDto
    {
        return $this->customerRepository->findById($customerId);
    }
}
