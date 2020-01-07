<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Response;

class VoidAuthorizationResponse
{
    /** @var null|float|int|string */
    public $remainingAuthorizedAmount;

    /** @var null|float|int|string */
    public $totalAuthorizedAmount;

    /** @var null|float|int|string */
    public $totalCapturedAmount;
}
