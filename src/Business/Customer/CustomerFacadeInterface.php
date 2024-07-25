<?php

namespace Src\Business\Customer;

use Src\Business\Customer\Shared\CustomerDto;

interface CustomerFacadeInterface
{
    public function getCustomerById(int $customerId): ?CustomerDto;
}
