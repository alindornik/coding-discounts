<?php

namespace OrdersDiscounts\Validator;

use PHPUnit\Framework\TestCase;
use Src\OrdersDiscounts\Validator\OrdersDiscountsBodyValidator;

class OrdersDiscountsBodyValidatorTest extends TestCase
{
    private OrdersDiscountsBodyValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new OrdersDiscountsBodyValidator();
    }

    public function testValidateOrdersKeyMissing()
    {
        $body = [];
        $this->assertEquals('orders key is missing', $this->validator->validate($body));
    }

    public function testValidateOrdersKeyNotArray()
    {
        $body = ['orders' => 'not an array'];
        $this->assertEquals('orders key should be an array', $this->validator->validate($body));
    }

    public function testValidateOrderIdKeyMissing()
    {
        $body = ['orders' => [['customer-id' => 1, 'items' => [], 'total' => 100]]];
        $this->assertEquals('order id key is missing', $this->validator->validate($body));
    }

    public function testValidateOrderCustomerIdKeyMissing()
    {
        $body = ['orders' => [['id' => 1, 'items' => [], 'total' => 100]]];
        $this->assertEquals('order customer-id key is missing', $this->validator->validate($body));
    }

    public function testValidateOrderItemsKeyMissing()
    {
        $body = ['orders' => [['id' => 1, 'customer-id' => 1, 'total' => 100]]];
        $this->assertEquals('order items key is missing', $this->validator->validate($body));
    }

    public function testValidateOrderItemsKeyNotArray()
    {
        $body = ['orders' => [['id' => 1, 'customer-id' => 1, 'items' => 'not an array', 'total' => 100]]];
        $this->assertEquals('order items key should be an array', $this->validator->validate($body));
    }

    public function testValidateItemProductIdKeyMissing()
    {
        $body = ['orders' => [['id' => 1, 'customer-id' => 1, 'items' => [['quantity' => 1, 'unit-price' => 100, 'total' => 100]], 'total' => 100]]];
        $this->assertEquals('item product-id key is missing', $this->validator->validate($body));
    }

    public function testValidateItemQuantityKeyMissing()
    {
        $body = ['orders' => [['id' => 1, 'customer-id' => 1, 'items' => [['product-id' => 1, 'unit-price' => 100, 'total' => 100]], 'total' => 100]]];
        $this->assertEquals('item quantity key is missing', $this->validator->validate($body));
    }

    public function testValidateItemUnitPriceKeyMissing()
    {
        $body = ['orders' => [['id' => 1, 'customer-id' => 1, 'items' => [['product-id' => 1, 'quantity' => 1, 'total' => 100]], 'total' => 100]]];
        $this->assertEquals('item unit-price key is missing', $this->validator->validate($body));
    }

    public function testValidateItemTotalKeyMissing()
    {
        $body = ['orders' => [['id' => 1, 'customer-id' => 1, 'items' => [['product-id' => 1, 'quantity' => 1, 'unit-price' => 100]], 'total' => 100]]];
        $this->assertEquals('item total key is missing', $this->validator->validate($body));
    }

    public function testValidateOrderTotalKeyMissing()
    {
        $body = ['orders' => [['id' => 1, 'customer-id' => 1, 'items' => [['product-id' => 1, 'quantity' => 1, 'unit-price' => 100, 'total' => 100]]]]];
        $this->assertEquals('order total key is missing', $this->validator->validate($body));
    }

    public function testValidateAllKeysPresent()
    {
        $body = ['orders' => [['id' => 1, 'customer-id' => 1, 'items' => [['product-id' => 1, 'quantity' => 1, 'unit-price' => 100, 'total' => 100]], 'total' => 100]]];
        $this->assertNull($this->validator->validate($body));
    }
}
