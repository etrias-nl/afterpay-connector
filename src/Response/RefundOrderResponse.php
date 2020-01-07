<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Response;

class RefundOrderResponse
{
    /** @var string[] */
    public $refundNumbers = [];

    /** @var null|float|int|string */
    public $totalAuthorizedAmount;

    /** @var null|float|int|string */
    public $totalCapturedAmount;

    /** @var null|float|int|string */
    public $totalRefundedAmount;
}
