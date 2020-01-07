<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Response;

class AuthorizePaymentResponse
{
    use AuthorizeResponseTrait;

    /** @var null|string */
    public $reservationId;

    /** @var null|\DateTimeInterface */
    public $expirationDate;
}
