<?php

namespace Src\OrdersDiscounts\Validator;

class OrdersDiscountsBodyValidator
{
    public function validate(array $body): ?string
    {
        if ($message = $this->validateOrders($body)) {
            return $message;
        }

        foreach ($body['orders'] as $order) {
            if ($message = $this->validateOrder($order)) {
                return $message;
            }
        }

        return null;
    }

    private function validateOrders(array $body): ?string
    {
        if (!isset($body['orders'])) {
            return 'orders key is missing';
        }

        if (!is_array($body['orders'])) {
            return 'orders key should be an array';
        }

        return null;
    }

    private function validateOrder(array $order): ?string
    {
        if (!isset($order['id'])) {
            return 'order id key is missing';
        }

        if (!isset($order['customer-id'])) {
            return 'order customer-id key is missing';
        }

        if (!isset($order['items'])) {
            return 'order items key is missing';
        }

        if (!is_array($order['items'])) {
            return 'order items key should be an array';
        }

        foreach ($order['items'] as $item) {
            if ($message = $this->validateItem($item)) {
                return $message;
            }
        }

        if (!isset($order['total'])) {
            return 'order total key is missing';
        }

        return null;
    }

    private function validateItem(array $item): ?string
    {
        if (!isset($item['product-id'])) {
            return 'item product-id key is missing';
        }

        if (!isset($item['quantity'])) {
            return 'item quantity key is missing';
        }

        if (!isset($item['unit-price'])) {
            return 'item unit-price key is missing';
        }

        if (!isset($item['total'])) {
            return 'item total key is missing';
        }

        return null;
    }
}
