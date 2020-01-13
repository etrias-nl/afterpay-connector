<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Request;

use Etrias\AfterPayConnector\Type\OrderSummary;

class CaptureRequest
{
    /** @var null|OrderSummary */
    protected $orderDetails;

    /** @var null|string */
    protected $invoiceNumber;

    /** @var null|string */
    protected $transactionReference;

    public function getOrderDetails(): ?OrderSummary
    {
        return $this->orderDetails;
    }

    public function setOrderDetails(?OrderSummary $orderDetails): self
    {
        $this->orderDetails = $orderDetails;

        return $this;
    }

    public function getInvoiceNumber(): ?string
    {
        return $this->invoiceNumber;
    }

    public function setInvoiceNumber(?string $invoiceNumber): self
    {
        $this->invoiceNumber = $invoiceNumber;

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
