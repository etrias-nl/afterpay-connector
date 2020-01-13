<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Type;

class Order
{
    use OrderSummaryTrait;

    /** @var null|string */
    protected $number;

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(?string $number): self
    {
        $this->number = $number;

        return $this;
    }
}
