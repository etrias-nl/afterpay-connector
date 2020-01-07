<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Response;

trait AuthorizeResponseTrait
{
    /** @var null|string */
    public $outcome;

    /** @var null|CustomerResponse */
    public $customer;

    /** @var null|CustomerResponse */
    public $deliveryCustomer;

    /** @var null|string */
    public $checkoutId;
}
