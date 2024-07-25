<?php

namespace Api\OrdersDiscounts\Controller;

use PHPUnit\Framework\TestCase;
use Src\Api\Http\Response;
use Src\Api\OrdersDiscounts\Builder\ResponseBuilder;
use Src\Api\OrdersDiscounts\Controller\OrdersDiscountsController;
use Src\Api\OrdersDiscounts\Mapper\OrdersDiscountsMapper;
use Src\Api\OrdersDiscounts\Validator\OrdersDiscountsBodyValidator;
use Src\Business\Order\OrderFacadeInterface;

class OrdersDiscountsControllerTest extends TestCase
{
    private OrdersDiscountsBodyValidator $orderDiscountBodyValidator;
    private OrdersDiscountsMapper $orderMapper;
    private OrderFacadeInterface $ordersFacade;
    private ResponseBuilder $responseBuilder;
    private OrdersDiscountsController $controller;

    protected function setUp(): void
    {
        $this->orderDiscountBodyValidator = $this->createMock(OrdersDiscountsBodyValidator::class);
        $this->orderMapper = $this->createMock(OrdersDiscountsMapper::class);
        $this->ordersFacade = $this->createMock(OrderFacadeInterface::class);
        $this->responseBuilder = $this->createMock(ResponseBuilder::class);

        $this->controller = new OrdersDiscountsController(
            $this->orderDiscountBodyValidator,
            $this->orderMapper,
            $this->ordersFacade,
            $this->responseBuilder
        );
    }

    public function testGetDiscountsValidationFails()
    {
        // Arrange
        $body = ['some' => 'data'];
        $errorMessage = 'Validation error';

        $this->orderDiscountBodyValidator->method('validate')->with($body)->willReturn($errorMessage);

        $expectedResponse = $this->createMock(Response::class);
        $this->responseBuilder->method('buildErrorResponse')->with($errorMessage)->willReturn($expectedResponse);

        // Act
        $result = $this->controller->getDiscounts($body);

        // Assert
        $this->assertSame($expectedResponse, $result);
    }

    public function testGetDiscountsValidationPasses()
    {
        // Arrange
        $body = ['some' => 'data'];
        $orderList = ['order1', 'order2'];

        $this->orderDiscountBodyValidator->method('validate')->with($body)->willReturn(null);
        $this->orderMapper->method('mapBodyToOrderDto')->with($body)->willReturn($orderList);
        $this->ordersFacade->method('calculateOrdersDiscounts')->with($orderList)->willReturn($orderList);

        $expectedResponse = $this->createMock(Response::class);
        $this->responseBuilder->method('buildSuccessResponse')->with($orderList)->willReturn($expectedResponse);

        // Act
        $result = $this->controller->getDiscounts($body);

        // Assert
        $this->assertSame($expectedResponse, $result);
    }
}
