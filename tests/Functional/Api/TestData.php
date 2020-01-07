<?php

declare(strict_types=1);

namespace Tests\Etrias\AfterPayConnector\Functional\Api;

use Etrias\AfterPayConnector\Type\Address;
use Etrias\AfterPayConnector\Type\CheckoutCustomer;
use Etrias\AfterPayConnector\Type\Order;
use Etrias\AfterPayConnector\Type\OrderItem;

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

    public static function order(): Order
    {
        return Order::forItems('TEST-'.bin2hex(random_bytes(10)), [
            OrderItem::forProduct('A', 'Product A', 1)
                ->withPrice(2, 1)
                ->withVat(1, 21),
            OrderItem::forProduct('B', 'Product B 😁', 3)
                ->withPrice(3.5, 2.25)
                ->withVat(1, 6),
        ]);
    }
}
