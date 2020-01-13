<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Request;

use Etrias\AfterPayConnector\Type\OrderSummary;

class VoidAuthorizationRequest
{
    /** @var null|OrderSummary */
    protected $cancellationDetails;

    /** @var null|string */
    protected $merchantId;

    /** @var null|string */
    protected $parentTransactionReference;

    public function getCancellationDetails(): ?OrderSummary
    {
        return $this->cancellationDetails;
    }

    public function setCancellationDetails(?OrderSummary $cancellationDetails): self
    {
        $this->cancellationDetails = $cancellationDetails;

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

    public function getParentTransactionReference(): ?string
    {
        return $this->parentTransactionReference;
    }

    public function setParentTransactionReference(?string $parentTransactionReference): self
    {
        $this->parentTransactionReference = $parentTransactionReference;

        return $this;
    }
}
