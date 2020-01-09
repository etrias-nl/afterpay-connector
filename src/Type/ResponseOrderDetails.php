<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Type;

class ResponseOrderDetails
{
    /** @var null|string */
    public $currency;

    /** @var null|CheckoutCustomer */
    public $customer;

    /** @var null|\DateTime */
    public $expirationDate;

    /** @var null|\DateTime */
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

    /** @var null|\DateTime */
    public $updatedAt;
}
