<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Request;

use Etrias\AfterPayConnector\Type\CheckoutCustomer;
use Etrias\AfterPayConnector\Type\Order;

trait AuthorizeRequestTrait
{
    /** @var null|CheckoutCustomer */
    public $customer;

    /** @var null|CheckoutCustomer */
    public $deliveryCustomer;

    /** @var null|Order */
    public $order;

    /** @var null|string */
    public $ourReference;

    /** @var null|string */
    public $yourReference;
}
