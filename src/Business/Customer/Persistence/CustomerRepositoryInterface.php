<?php

namespace Src\Business\Customer\Persistence;

use Src\Business\Customer\Shared\CustomerDto;

interface CustomerRepositoryInterface
{
    public function findById(int $id): ?CustomerDto;
}
