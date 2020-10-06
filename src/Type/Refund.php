<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Type;

class Refund
{
    /** @var null|float|int|string */
    protected $amount;

    /** @var null|float|int|string */
    protected $balance;

    /** @var null|string */
    protected $captureNumber;

    /** @var null|string */
    protected $currency;

    /** @var null|string */
    protected $customerNumber;

    /** @var null|\DateTime */
    protected $insertedAt;

    /** @var null|string */
    protected $orderNumber;

    /** @var RefundItem[] */
    protected $refundItems = [];

    /** @var null|string */
    protected $refundNumber;

    /** @var null|string */
    protected $reservationId;

    /** @var null|string */
    protected $transactionReference;

    /** @var null|\DateTime */
    protected $updatedAt;

    /**
     * @return null|float|int|string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param null|float|int|string $amount
     *
     * @return Refund
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return null|float|int|string
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * @param null|float|int|string $balance
     *
     * @return Refund
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;

        return $this;
    }

    public function getCaptureNumber(): ?string
    {
        return $this->captureNumber;
    }

    public function setCaptureNumber(?string $captureNumber): self
    {
        $this->captureNumber = $captureNumber;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(?string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getCustomerNumber(): ?string
    {
        return $this->customerNumber;
    }

    public function setCustomerNumber(?string $customerNumber): self
    {
        $this->customerNumber = $customerNumber;

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
     * @return RefundItem[]
     */
    public function getRefundItems(): array
    {
        return $this->refundItems;
    }

    /**
     * @param RefundItem[] $refundItems
     */
    public function setRefundItems(array $refundItems): self
    {
        $this->refundItems = $refundItems;

        return $this;
    }

    public function getRefundNumber(): ?string
    {
        return $this->refundNumber;
    }

    public function setRefundNumber(?string $refundNumber): self
    {
        $this->refundNumber = $refundNumber;

        return $this;
    }

    public function getReservationId(): ?string
    {
        return $this->reservationId;
    }

    public function setReservationId(?string $reservationId): self
    {
        $this->reservationId = $reservationId;

        return $this;
    }

    public function getTransactionReference(): ?string
    {
        return $this->transactionReference;
    }

    public function setTransactionReference(?string $transactionReference): self
    {
        $this->transactionReference = $transactionReference;

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
