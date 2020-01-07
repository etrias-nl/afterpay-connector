<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Type;

class Refund
{
    use ReferencesTrait;

    /** @var null|float|int|string */
    public $amount;

    /** @var null|float|int|string */
    public $balance;

    /** @var null|string */
    public $captureNumber;

    /** @var null|string */
    public $currency;

    /** @var null|string */
    public $customerNumber;

    /** @var null|\DateTimeInterface */
    public $insertedAt;

    /** @var null|string */
    public $orderNumber;

    /** @var RefundItem[] */
    public $refundItems = [];

    /** @var null|string */
    public $refundNumber;

    /** @var null|string */
    public $reservationId;

    /** @var null|\DateTimeInterface */
    public $updatedAt;
}
