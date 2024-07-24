<?php

namespace Src\OrdersDiscounts\Controller;

use Src\Api\Http\Response;
use Src\OrdersDiscounts\Mapper\OrdersDiscountsMapper;
use Src\OrdersDiscounts\Validator\OrdersDiscountsBodyValidator;

class OrdersDiscountsController {

    public function __construct(
        public OrdersDiscountsBodyValidator $orderDiscountBodyValidator,
        public OrdersDiscountsMapper $orderMapper,
    ) {
    }

    public function getDiscounts(array $body): Response {
        if ($message = $this->orderDiscountBodyValidator->validate($body)) {
            return new Response(400, json_encode(['error' => $message]));
        }

        $orderList = $this->orderMapper->mapBodyToOrderDto($body);

        // Calculate discounts

        return new Response(200, json_encode($orderList));
    }
}
