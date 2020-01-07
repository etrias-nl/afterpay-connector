<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Response;

class AuthorizePaymentResponse
{
    public const OUTCOME_ACCEPTED = 'Accepted';
    public const OUTCOME_PENDING = 'Pending';
    public const OUTCOME_REJECTED = 'Rejected';
    public const OUTCOME_NOT_EVALUATED = 'NotEvaluated';

    /** @var null|string */
    public $outcome;

    /** @var null|CustomerResponse */
    public $customer;

    /** @var null|CustomerResponse */
    public $deliveryCustomer;

    /** @var null|string */
    public $checkoutId;

    /** @var null|string */
    public $reservationId;

    /** @var null|\DateTimeInterface */
    public $expirationDate;
}
