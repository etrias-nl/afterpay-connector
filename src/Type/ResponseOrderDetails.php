<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Type;

class ResponseOrderDetails
{
    /** @var null|string */
    protected $currency;

    /** @var null|CheckoutCustomer */
    protected $customer;

    /** @var null|\DateTime */
    protected $expirationDate;

    /** @var null|\DateTime */
    protected $insertedAt;

    /** @var null|string */
    protected $orderId;

    /** @var null|OrderItemExtended[] */
    protected $orderItems = [];

    /** @var null|string */
    protected $orderNumber;

    /** @var null|float|int|string */
    protected $totalGrossAmount;

    /** @var null|float|int|string */
    protected $totalNetAmount;

    /** @var null|\DateTime */
    protected $updatedAt;

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(?string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getCustomer(): ?CheckoutCustomer
    {
        return $this->customer;
    }

    public function setCustomer(?CheckoutCustomer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getExpirationDate(): ?\DateTime
    {
        return $this->expirationDate;
    }

    public function setExpirationDate(?\DateTime $expirationDate): self
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }

    public function getInsertedAt(): ?\DateTime
    {
        return $this->insertedAt;
    }

    public function setInsertedAt(?\DateTime $insertedAt): self
    {
        $this->insertedAt = $insertedAt;

        return $this;
    }

    public function getOrderId(): ?string
    {
        return $this->orderId;
    }

    public function setOrderId(?string $orderId): self
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * @return null|OrderItemExtended[]
     */
    public function getOrderItems(): ?array
    {
        return $this->orderItems;
    }

    /**
     * @param null|OrderItemExtended[] $orderItems
     */
    public function setOrderItems(?array $orderItems): self
    {
        $this->orderItems = $orderItems;

        return $this;
    }

    public function getOrderNumber(): ?string
    {
        return $this->orderNumber;
    }

    public function setOrderNumber(?string $orderNumber): self
    {
        $this->orderNumber = $orderNumber;

        return $this;
    }

    /**
     * @return null|float|int|string
     */
    public function getTotalGrossAmount()
    {
        return $this->totalGrossAmount;
    }

    /**
     * @param null|float|int|string $totalGrossAmount
     *
     * @return ResponseOrderDetails
     */
    public function setTotalGrossAmount($totalGrossAmount)
    {
        $this->totalGrossAmount = $totalGrossAmount;

        return $this;
    }

    /**
     * @return null|float|int|string
     */
    public function getTotalNetAmount()
    {
        return $this->totalNetAmount;
    }

    /**
     * @param null|float|int|string $totalNetAmount
     *
     * @return ResponseOrderDetails
     */
    public function setTotalNetAmount($totalNetAmount)
    {
        $this->totalNetAmount = $totalNetAmount;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
