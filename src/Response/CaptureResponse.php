<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Response;

class CaptureResponse
{
    /** @var null|float|int|string */
    public $authorizedAmount;

    /** @var null|float|int|string */
    public $capturedAmount;

    /** @var null|string */
    public $captureNumber;

    /** @var null|float|int|string */
    public $remainingAuthorizedAmount;
}
