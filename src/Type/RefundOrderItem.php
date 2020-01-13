<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Type;

class RefundOrderItem
{
    use OrderItemTrait;

    /** @var null|string */
    protected $refundType;

    public function getRefundType(): ?string
    {
        return $this->refundType;
    }

    public function setRefundType(?string $refundType): self
    {
        $this->refundType = $refundType;

        return $this;
    }
}
