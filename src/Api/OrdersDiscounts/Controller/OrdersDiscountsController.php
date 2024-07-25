<?php

namespace Src\Api\OrdersDiscounts\Controller;

use Src\Api\Http\Response;
use Src\Api\OrdersDiscounts\Builder\ResponseBuilder;
use Src\Api\OrdersDiscounts\Mapper\OrdersDiscountsMapper;
use Src\Api\OrdersDiscounts\Validator\OrdersDiscountsBodyValidator;
use Src\Business\Order\OrderFacadeInterface;

class OrdersDiscountsController {

    public function __construct(
        protected OrdersDiscountsBodyValidator $orderDiscountBodyValidator,
        protected OrdersDiscountsMapper        $orderMapper,
        protected OrderFacadeInterface         $ordersFacade,
        protected ResponseBuilder              $responseBuilder,
    ) {
    }

    public function getDiscounts(array $body): Response {
        if ($message = $this->orderDiscountBodyValidator->validate($body)) {
            return $this->responseBuilder->buildErrorResponse($message);
        }

        $orderList = $this->orderMapper->mapBodyToOrderDto($body);
        $orderList = $this->ordersFacade->calculateOrdersDiscounts($orderList);

        return $this->responseBuilder->buildSuccessResponse($orderList);
    }
}
