<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Request;

use Etrias\AfterPayConnector\Type\CheckoutCustomer;
use Etrias\AfterPayConnector\Type\Order;
use Etrias\AfterPayConnector\Type\ReferencesTrait;

trait AuthorizeRequestTrait
{
    use ReferencesTrait;

    /** @var null|CheckoutCustomer */
    public $customer;

    /** @var null|CheckoutCustomer */
    public $deliveryCustomer;

    /** @var null|Order */
    public $order;
}
