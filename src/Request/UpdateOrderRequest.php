<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Request;

use Etrias\AfterPayConnector\Type\OrderSummary;
use Etrias\AfterPayConnector\Type\ReferencesTrait;

class UpdateOrderRequest
{
    use ReferencesTrait;

    /** @var null|OrderSummary */
    protected $updateOrderSummary;

    public function getUpdateOrderSummary(): ?OrderSummary
    {
        return $this->updateOrderSummary;
    }

    public function setUpdateOrderSummary(?OrderSummary $updateOrderSummary): self
    {
        $this->updateOrderSummary = $updateOrderSummary;

        return $this;
    }
}
