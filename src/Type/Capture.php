<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Type;

class Capture
{
    use ReferencesTrait;

    /** @var null|float|int|string */
    protected $amount;

    /** @var null|float|int|string */
    protected $balance;

    /** @var CaptureItem[] */
    protected $captureItems = [];

    /** @var null|string */
    protected $captureNumber;

    /** @var null|string */
    protected $currency;

    /** @var null|string */
    protected $customerNumber;

    /** @var null|\DateTime */
    protected $dueDate;

    /** @var null|\DateTime */
    protected $insertedAt;

    /** @var null|\DateTime */
    protected $invoiceDate;

    /** @var null|\DateTime */
    protected $orderDate;

    /** @var null|string */
    protected $orderNumber;

    /** @var null|string */
    protected $reservationId;

    /** @var null|float|int|string */
    protected $totalRefundedAmount;

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
     * @return Capture
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
     * @return Capture
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;

        return $this;
    }

    /**
     * @return CaptureItem[]
     */
    public function getCaptureItems(): array
    {
        return $this->captureItems;
    }

    /**
     * @param CaptureItem[] $captureItems
     */
    public function setCaptureItems(array $captureItems): self
    {
        $this->captureItems = $captureItems;

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

    public function getDueDate(): ?\DateTime
    {
        return $this->dueDate;
    }

    public function setDueDate(?\DateTime $dueDate): self
    {
        $this->dueDate = $dueDate;

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

    public function getInvoiceDate(): ?\DateTime
    {
        return $this->invoiceDate;
    }

    public function setInvoiceDate(?\DateTime $invoiceDate): self
    {
        $this->invoiceDate = $invoiceDate;

        return $this;
    }

    public function getOrderDate(): ?\DateTime
    {
        return $this->orderDate;
    }

    public function setOrderDate(?\DateTime $orderDate): self
    {
        $this->orderDate = $orderDate;

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

    public function getReservationId(): ?string
    {
        return $this->reservationId;
    }

    public function setReservationId(?string $reservationId): self
    {
        $this->reservationId = $reservationId;

        return $this;
    }

    /**
     * @return null|float|int|string
     */
    public function getTotalRefundedAmount()
    {
        return $this->totalRefundedAmount;
    }

    /**
     * @param null|float|int|string $totalRefundedAmount
     *
     * @return Capture
     */
    public function setTotalRefundedAmount($totalRefundedAmount)
    {
        $this->totalRefundedAmount = $totalRefundedAmount;

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
