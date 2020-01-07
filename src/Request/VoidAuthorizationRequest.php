<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Request;

use Etrias\AfterPayConnector\Type\OrderSummary;

class VoidAuthorizationRequest
{
    /** @var null|OrderSummary */
    public $cancellationDetails;

    /** @var null|string */
    public $merchantId;
}
