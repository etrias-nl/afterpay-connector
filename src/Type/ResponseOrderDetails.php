<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Type;

class ResponseOrderDetails
{
    /** @var null|string */
    public $currency;

    /** @var null|CheckoutCustomer */
    public $customer;

    /** @var null|\DateTimeInterface */
    public $expirationDate;

    /** @var null|\DateTimeInterface */
    public $insertedAt;

    /** @var null|string */
    public $orderId;

    /** @var null|OrderItemExtended[] */
    public $orderItems = [];

    /** @var null|string */
    public $orderNumber;

    /** @var null|float|int|string */
    public $totalGrossAmount;

    /** @var null|float|int|string */
    public $totalNetAmount;

    /** @var null|\DateTimeInterface */
    public $updatedAt;
}
