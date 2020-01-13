<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Response;

use Etrias\AfterPayConnector\Type\Refund;

class GetAllRefundsResponse
{
    /** @var Refund[] */
    protected $refunds = [];

    /**
     * @return Refund[]
     */
    public function getRefunds(): array
    {
        return $this->refunds;
    }

    /**
     * @param Refund[] $refunds
     */
    public function setRefunds(array $refunds): self
    {
        $this->refunds = $refunds;

        return $this;
    }
}
