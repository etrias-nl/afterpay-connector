<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Response;

use Etrias\AfterPayConnector\Type\ResponseMessage;

trait AuthorizeResponseTrait
{
    /** @var null|string */
    protected $outcome;

    /** @var null|CustomerResponse */
    protected $customer;

    /** @var null|CustomerResponse */
    protected $deliveryCustomer;

    /** @var null|string */
    protected $checkoutId;

    /** @var ResponseMessage[] */
    protected $riskCheckMessages = [];

    public function getOutcome(): ?string
    {
        return $this->outcome;
    }

    public function setOutcome(?string $outcome): self
    {
        $this->outcome = $outcome;

        return $this;
    }

    public function getCustomer(): ?CustomerResponse
    {
        return $this->customer;
    }

    public function setCustomer(?CustomerResponse $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getDeliveryCustomer(): ?CustomerResponse
    {
        return $this->deliveryCustomer;
    }

    public function setDeliveryCustomer(?CustomerResponse $deliveryCustomer): self
    {
        $this->deliveryCustomer = $deliveryCustomer;

        return $this;
    }

    public function getCheckoutId(): ?string
    {
        return $this->checkoutId;
    }

    public function setCheckoutId(?string $checkoutId): self
    {
        $this->checkoutId = $checkoutId;

        return $this;
    }

    /**
     * @return ResponseMessage[]
     */
    public function getRiskCheckMessages(): array
    {
        return $this->riskCheckMessages;
    }

    public function setRiskCheckMessages($riskCheckMessages): self
    {
        $this->riskCheckMessages = $riskCheckMessages;

        return $this;
    }
}
