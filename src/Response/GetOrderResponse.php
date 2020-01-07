<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Response;

use Etrias\AfterPayConnector\Type\Cancellation;
use Etrias\AfterPayConnector\Type\Capture;
use Etrias\AfterPayConnector\Type\Payment;
use Etrias\AfterPayConnector\Type\Refund;
use Etrias\AfterPayConnector\Type\ResponseOrderDetails;

class GetOrderResponse
{
    /** @var Cancellation[] */
    public $cancellations = [];

    /** @var Capture[] */
    public $captures = [];

    /** @var null|ResponseOrderDetails */
    public $orderDetails;

    /** @var null|Payment */
    public $payment;

    /** @var Refund[] */
    public $refunds = [];
}
