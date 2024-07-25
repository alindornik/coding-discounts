<?php

namespace Api\OrdersDiscounts\Builder;

use PHPUnit\Framework\TestCase;
use Src\Api\Http\Response;
use Src\Api\OrdersDiscounts\Builder\ResponseBuilder;

class ResponseBuilderTest extends TestCase
{
    private ResponseBuilder $responseBuilder;

    protected function setUp(): void
    {
        $this->responseBuilder = new ResponseBuilder();
    }

    public function testBuildErrorResponse(): void
    {
        //Arrange
        $message = 'An error occurred';

        //Act
        $response = $this->responseBuilder->buildErrorResponse($message);

        //Assert
        $this->assertResponse($response, 400, ['error' => $message]);
    }

    public function testBuildSuccessResponse(): void
    {
        //Arrange
        $orderList = [
            ['id' => 1, 'customer-id' => 1, 'total' => 100],
            ['id' => 2, 'customer-id' => 2, 'total' => 200]
        ];

        //Act
        $response = $this->responseBuilder->buildSuccessResponse($orderList);

        //Assert
        $this->assertResponse($response, 200, $orderList);
    }

    private function assertResponse(Response $response, int $expectedStatusCoe, array $expectedMessage): void
    {
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals($expectedStatusCoe, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(json_encode($expectedMessage), $response->getBody());
    }
}
