<?php

namespace Src\Business\Customer\Persistence;

use Src\Business\Customer\Shared\CustomerDto;

interface CustomerRepositoryInterface
{
    // Normally repository should return a entity object, but for simplicity, I will return a DTO object
    public function findById(int $id): ?CustomerDto;
}
