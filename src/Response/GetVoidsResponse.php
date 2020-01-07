<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Response;

use Etrias\AfterPayConnector\Type\Cancellation;

class GetVoidsResponse
{
    /** @var Cancellation[] */
    public $cancellations = [];
}
