<?php

namespace Src\Business\Product\Persistence;

use Src\Business\Product\Shared\ProductDto;

class ProductRepository implements ProductRepositoryInterface
{
    public function findById(string $id): ?ProductDto
    {
        $json = file_get_contents( 'data/products.json');
        $productList = json_decode($json, true);

        foreach ($productList as $product) {
            if ($product['id'] == $id) {
                $productDto = new ProductDto();
                $productDto->setId($product['id']);
                $productDto->setDescription($product['description']);
                $productDto->setCategory($product['category']);
                $productDto->setPrice($product['price']);
                return $productDto;
            }
        }

        return null;
    }
}
