<?php

namespace Src\Business\Product;

use Src\Business\Product\Persistence\ProductRepositoryInterface;
use Src\Business\Product\Shared\ProductDto;

class ProductFacade implements ProductFacadeInterface
{
    public function __construct(protected ProductRepositoryInterface $productRepository)
    {
    }

    public function getProductById(string $productId): ?ProductDto
    {
        return $this->productRepository->findById($productId);
    }
}
