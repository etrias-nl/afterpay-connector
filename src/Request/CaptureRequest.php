<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Request;

use Etrias\AfterPayConnector\Type\OrderSummary;

class CaptureRequest
{
    /** @var null|OrderSummary */
    public $orderDetails;

    /** @var null|string */
    public $invoiceNumber;

    /** @var null|string */
    public $transactionReference;
}
