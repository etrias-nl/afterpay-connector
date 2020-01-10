<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Response;

class AuthorizePaymentResponse
{
    use AuthorizeResponseTrait;

    /** @var null|string */
    public $reservationId;

    /** @var null|\DateTime */
    public $expirationDate;
}
