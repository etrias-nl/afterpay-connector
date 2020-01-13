<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Type;

class CancellationItem
{
    use OrderItemTrait;

    /** @var null|string */
    protected $cancellationNumber;

    public function getCancellationNumber(): ?string
    {
        return $this->cancellationNumber;
    }

    public function setCancellationNumber(?string $cancellationNumber): self
    {
        $this->cancellationNumber = $cancellationNumber;

        return $this;
    }
}
