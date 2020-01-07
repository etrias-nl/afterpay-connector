<?php

declare(strict_types=1);

namespace Tests\Etrias\AfterPayConnector\Functional\Api;

use Etrias\AfterPayConnector\Type\Address;
use Etrias\AfterPayConnector\Type\CheckoutCustomer;
use Etrias\AfterPayConnector\Type\Order;
use Etrias\AfterPayConnector\Type\OrderItem;
use Etrias\AfterPayConnector\Type\OrderSummary;
use Etrias\AfterPayConnector\Type\RefundOrderItem;

abstract class TestData
{
    public static function checkoutCustomer(): CheckoutCustomer
    {
        $customer = CheckoutCustomer::forPerson('john.doe@domain.test')
            ->withName(CheckoutCustomer::SALUTATION_MR, 'John', 'Doe 😁')
            ->withBirthDate(28, 7, 1987)
        ;
        $customer->address = self::address();

        return $customer;
    }

    public static function address(): Address
    {
        return Address::forPlace('NL', '1111AA', 'Test stad 😁')
            ->withStreet('Straatnaam 😁', '1', 'A')
        ;
    }

    public static function order(?string $number = null): Order
    {
        $order = Order::forItems(self::orderItems());
        $order->number = $number ?? self::orderNumber();

        return $order;
    }

    public static function orderSummary(): OrderSummary
    {
        return OrderSummary::forItems(self::orderItems());
    }

    /**
     * @return OrderItem[]
     */
    public static function orderItems(): array
    {
        return [
            OrderItem::forProduct('A', 'Product A', 1)
                ->withPrice(10, 2.5, 21),
            OrderItem::forProduct('B', 'Product B 😁', 3)
                ->withPrice(5.5, 3, 6),
        ];
    }

    public static function refundOrderItem(): RefundOrderItem
    {
        return RefundOrderItem::forProduct('A', 'Product A', 1)
            ->withPrice(10, 2.5, 21)
        ;
    }

    public static function orderNumber(): string
    {
        return 'TEST-'.bin2hex(random_bytes(10));
    }
}
