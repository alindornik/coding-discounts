<?php

namespace Src\Business\Discount\Shared;

enum DiscountType: string
{
    case CUSTOMER_OVER_LIMIT = 'customer_over_limit';
    case PRODUCT_CATEGORY_QUANTITY = 'product_category_quantity';
    case PRODUCT_CATEGORY_PERCENTAGE_OF_CHEAPEST = 'product_category_percentage_of_cheapest';
}
