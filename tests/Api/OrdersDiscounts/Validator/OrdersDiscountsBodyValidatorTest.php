<?php

namespace Api\OrdersDiscounts\Validator;

use PHPUnit\Framework\TestCase;
use Src\Api\OrdersDiscounts\Validator\OrdersDiscountsBodyValidator;

class OrdersDiscountsBodyValidatorTest extends TestCase
{
    private OrdersDiscountsBodyValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new OrdersDiscountsBodyValidator();
    }

    public function testValidateOrdersKeyMissing(): void
    {
        // Arrange
        $body = [];

        // Act & Assert
        $this->assertEquals('orders key is missing', $this->validator->validate($body));
    }

    public function testValidateOrdersKeyNotArray(): void
    {
        // Arrange
        $body = ['orders' => 'not an array'];

        // Act & Assert
        $this->assertEquals('orders key should be an array', $this->validator->validate($body));
    }

    public function testValidateOrderIdKeyMissing(): void
    {
        // Arrange
        $body = ['orders' => [['customer-id' => 1, 'items' => [], 'total' => 100]]];

        // Act & Assert
        $this->assertEquals('order id key is missing', $this->validator->validate($body));
    }

    public function testValidateOrderCustomerIdKeyMissing(): void
    {
        // Arrange
        $body = ['orders' => [['id' => 1, 'items' => [], 'total' => 100]]];

        // Act & Assert
        $this->assertEquals('order customer-id key is missing', $this->validator->validate($body));
    }

    public function testValidateOrderItemsKeyMissing(): void
    {
        // Arrange
        $body = ['orders' => [['id' => 1, 'customer-id' => 1, 'total' => 100]]];

        // Act & Assert
        $this->assertEquals('order items key is missing', $this->validator->validate($body));
    }

    public function testValidateOrderItemsKeyNotArray(): void
    {
        // Arrange
        $body = ['orders' => [['id' => 1, 'customer-id' => 1, 'items' => 'not an array', 'total' => 100]]];

        // Act & Assert
        $this->assertEquals('order items key should be an array', $this->validator->validate($body));
    }

    public function testValidateItemProductIdKeyMissing(): void
    {
        // Arrange
        $body = ['orders' => [['id' => 1, 'customer-id' => 1, 'items' => [['quantity' => 1, 'unit-price' => 100, 'total' => 100]], 'total' => 100]]];

        // Act & Assert
        $this->assertEquals('item product-id key is missing', $this->validator->validate($body));
    }

    public function testValidateItemQuantityKeyMissing(): void
    {
        // Arrange
        $body = ['orders' => [['id' => 1, 'customer-id' => 1, 'items' => [['product-id' => 1, 'unit-price' => 100, 'total' => 100]], 'total' => 100]]];

        // Act & Assert
        $this->assertEquals('item quantity key is missing', $this->validator->validate($body));
    }

    public function testValidateItemUnitPriceKeyMissing(): void
    {
        // Arrange
        $body = ['orders' => [['id' => 1, 'customer-id' => 1, 'items' => [['product-id' => 1, 'quantity' => 1, 'total' => 100]], 'total' => 100]]];

        // Act & Assert
        $this->assertEquals('item unit-price key is missing', $this->validator->validate($body));
    }

    public function testValidateItemTotalKeyMissing(): void
    {
        // Arrange
        $body = ['orders' => [['id' => 1, 'customer-id' => 1, 'items' => [['product-id' => 1, 'quantity' => 1, 'unit-price' => 100]], 'total' => 100]]];

        // Act & Assert
        $this->assertEquals('item total key is missing', $this->validator->validate($body));
    }

    public function testValidateOrderTotalKeyMissing(): void
    {
        // Arrange
        $body = ['orders' => [['id' => 1, 'customer-id' => 1, 'items' => [['product-id' => 1, 'quantity' => 1, 'unit-price' => 100, 'total' => 100]]]]];

        // Act & Assert
        $this->assertEquals('order total key is missing', $this->validator->validate($body));
    }

    public function testValidateAllKeysPresent(): void
    {
        // Arrange
        $body = ['orders' => [['id' => 1, 'customer-id' => 1, 'items' => [['product-id' => 1, 'quantity' => 1, 'unit-price' => 100, 'total' => 100]], 'total' => 100]]];

        // Act & Assert
        $this->assertNull($this->validator->validate($body));
    }
}
