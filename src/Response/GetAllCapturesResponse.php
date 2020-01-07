<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Response;

use Etrias\AfterPayConnector\Type\Capture;

class GetAllCapturesResponse
{
    /** @var Capture[] */
    public $captures = [];
}
