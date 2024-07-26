<?php

namespace Src\Business\Product\Persistence;

use Src\Business\Product\Shared\ProductDto;

interface ProductRepositoryInterface
{
    public function findById(string $id): ?ProductDto;
}
