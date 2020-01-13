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
    protected $customer;

    /** @var null|CheckoutCustomer */
    protected $deliveryCustomer;

    /** @var null|Order */
    protected $order;

    public function getCustomer(): ?CheckoutCustomer
    {
        return $this->customer;
    }

    public function setCustomer(?CheckoutCustomer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getDeliveryCustomer(): ?CheckoutCustomer
    {
        return $this->deliveryCustomer;
    }

    public function setDeliveryCustomer(?CheckoutCustomer $deliveryCustomer): self
    {
        $this->deliveryCustomer = $deliveryCustomer;

        return $this;
    }

    public function getOrder(): ?Order
    {
        return $this->order;
    }

    public function setOrder(?Order $order): self
    {
        $this->order = $order;

        return $this;
    }
}
