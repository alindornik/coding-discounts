<?php

namespace Src\Business\Product\Persistence;

use Src\Business\Product\Shared\ProductDto;

interface ProductRepositoryInterface
{
    // Normally repository should return a entity object, but for simplicity, I will return a DTO object
    public function findById(string $id): ?ProductDto;
}
