<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Request;

use Etrias\AfterPayConnector\Type\RefundOrderItem;

class RefundOrderRequest
{
    /** @var null|string */
    protected $captureNumber;

    /** @var RefundOrderItem[] */
    protected $items = [];

    /** @var null|string */
    protected $creditNoteNumber;

    /** @var null|string */
    protected $merchantId;

    /** @var null|string */
    protected $refundType;

    /** @var null|string */
    protected $transactionReference;

    public function getCaptureNumber(): ?string
    {
        return $this->captureNumber;
    }

    public function setCaptureNumber(?string $captureNumber): self
    {
        $this->captureNumber = $captureNumber;

        return $this;
    }

    /**
     * @return RefundOrderItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param RefundOrderItem[] $items
     */
    public function setItems(array $items): self
    {
        $this->items = $items;

        return $this;
    }

    public function addItem(RefundOrderItem $item): self
    {
        $this->items[] = $item;

        return $this;
    }

    public function getCreditNoteNumber(): ?string
    {
        return $this->creditNoteNumber;
    }

    public function setCreditNoteNumber(?string $creditNoteNumber): self
    {
        $this->creditNoteNumber = $creditNoteNumber;

        return $this;
    }

    public function getMerchantId(): ?string
    {
        return $this->merchantId;
    }

    public function setMerchantId(?string $merchantId): self
    {
        $this->merchantId = $merchantId;

        return $this;
    }

    public function getRefundType(): ?string
    {
        return $this->refundType;
    }

    public function setRefundType(?string $refundType): self
    {
        $this->refundType = $refundType;

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
}
