<?php

declare(strict_types=1);

namespace Tests\Etrias\AfterPayConnector\Functional\Api;

use Etrias\AfterPayConnector\Type\Address;
use Etrias\AfterPayConnector\Type\CheckoutCustomer;
use Etrias\AfterPayConnector\Type\CustomerRisk;
use Etrias\AfterPayConnector\Type\Order;
use Etrias\AfterPayConnector\Type\OrderItem;
use Etrias\AfterPayConnector\Type\OrderSummary;
use Etrias\AfterPayConnector\Type\RefundOrderItem;

abstract class TestData
{
    public static function checkoutCustomer(): CheckoutCustomer
    {
        $customer = new CheckoutCustomer();
        $customer
            ->setCustomerCategory(CheckoutCustomer::CATEGORY_PERSON)
            ->setEmail('john.doe@domain.test')
            ->setSalutation(CheckoutCustomer::SALUTATION_MR)
            ->setFirstName('John')
            ->setLastName('Doë')
            ->setBirthDate((new \DateTime())->setTimestamp(mktime(0, 0, 0, 7, 28, 1987)))
            ->setAddress(self::address())
            ->setRiskData(self::customerRisk())
        ;

        return $customer;
    }

    public static function customerRisk(): CustomerRisk
    {
        $risk = new CustomerRisk();
        $risk->setIpAddress('127.0.0.1');

        return $risk;
    }

    public static function address(): Address
    {
        $address = new Address();
        $address
            ->setPostalCode('1111AA')
            ->setPostalPlace('Test stad 😁')
            ->setCountryCode('NL')
            ->setStreet('Straatnaam 😁')
            ->setStreetNumber('1')
            ->setStreetNumberAdditional('A')
        ;

        return $address;
    }

    public static function order(?string $number = null): Order
    {
        $order = new Order();
        $order
            ->setNumber($number ?? self::orderNumber())
            ->setItems(self::orderItems())
            ->setTotalGrossAmount(38)
            ->setTotalNetAmount(26.5)
        ;

        return $order;
    }

    public static function orderSummary(): OrderSummary
    {
        $orderSummary = new OrderSummary();
        $orderSummary
            ->setItems(self::orderItems())
            ->setTotalGrossAmount(38)
            ->setTotalNetAmount(26.5)
        ;

        return $orderSummary;
    }

    /**
     * @return OrderItem[]
     */
    public static function orderItems(): array
    {
        $orderItem1 = new OrderItem();
        $orderItem1
            ->setProductId('A')
            ->setDescription('Product A')
            ->setQuantity(1)
            ->setNetUnitPrice(10)
            ->setGrossUnitPrice(12.5)
            ->setVatAmount(2.5)
            ->setVatPercent(21)
        ;

        $orderItem2 = new OrderItem();
        $orderItem2
            ->setProductId('B')
            ->setDescription('Product B 😁')
            ->setQuantity(3)
            ->setNetUnitPrice(5.5)
            ->setGrossUnitPrice(8.5)
            ->setVatAmount(3)
            ->setVatPercent(6)
        ;

        return [$orderItem1, $orderItem2];
    }

    public static function refundOrderItem(): RefundOrderItem
    {
        $orderItem = new RefundOrderItem();
        $orderItem
            ->setProductId('A')
            ->setDescription('Product A')
            ->setDescription('Product A')
            ->setQuantity(1)
            ->setNetUnitPrice(10)
            ->setGrossUnitPrice(12.5)
            ->setVatAmount(2.5)
            ->setVatPercent(21)
        ;

        return  $orderItem;
    }

    public static function orderNumber(): string
    {
        return 'TEST-'.bin2hex(random_bytes(5));
    }
}
