<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Type;

class Capture
{
    use ReferencesTrait;

    /** @var null|float|int|string */
    public $amount;

    /** @var null|float|int|string */
    public $balance;

    /** @var CaptureItem[] */
    public $captureItems = [];

    /** @var null|string */
    public $captureNumber;

    /** @var null|string */
    public $currency;

    /** @var null|string */
    public $customerNumber;

    /** @var null|\DateTimeInterface */
    public $dueDate;

    /** @var null|\DateTimeInterface */
    public $insertedAt;

    /** @var null|\DateTimeInterface */
    public $invoiceDate;

    /** @var null|\DateTimeInterface */
    public $orderDate;

    /** @var null|string */
    public $orderNumber;

    /** @var null|string */
    public $reservationId;

    /** @var null|float|int|string */
    public $totalRefundedAmount;

    /** @var null|\DateTimeInterface */
    public $updatedAt;
}
