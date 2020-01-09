<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Response;

class UpdateOrderResponse
{
    /** @var null|string */
    public $checkoutId;

    /** @var null|\DateTime */
    public $expirationDate;

    /** @var null|string */
    public $outcome;

    /** @var null|string */
    public $reservationId;
}
