<?php

namespace Src\Api\OrdersDiscounts\Builder;

use Src\Api\Http\Response;

class ResponseBuilder
{
    public function buildErrorResponse(string $message): Response
    {
        return new Response(400, json_encode(['error' => $message]));
    }

    public function buildSuccessResponse(array $orderList): Response
    {
        return new Response(200, json_encode($orderList));
    }
}
