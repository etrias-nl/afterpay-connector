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

    /** @var null|\DateTime */
    public $dueDate;

    /** @var null|\DateTime */
    public $insertedAt;

    /** @var null|\DateTime */
    public $invoiceDate;

    /** @var null|\DateTime */
    public $orderDate;

    /** @var null|string */
    public $orderNumber;

    /** @var null|string */
    public $reservationId;

    /** @var null|float|int|string */
    public $totalRefundedAmount;

    /** @var null|\DateTime */
    public $updatedAt;
}
