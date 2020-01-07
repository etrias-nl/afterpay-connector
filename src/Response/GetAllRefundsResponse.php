<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Response;

use Etrias\AfterPayConnector\Type\Refund;

class GetAllRefundsResponse
{
    /** @var Refund[] */
    public $refunds = [];
}
