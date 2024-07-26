<?php

namespace Src\Business\Product;

use Src\Business\Product\Shared\ProductDto;

interface ProductFacadeInterface
{
    public function getProductById(string $productId): ?ProductDto;
}
