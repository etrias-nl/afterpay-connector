<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Type;

class Cancellation
{
    /** @var null|string */
    protected $cancellationAmount;

    /** @var CancellationItem[] */
    protected $cancellationItems = [];

    /** @var null|string */
    protected $cancellationNo;

    public function getCancellationAmount(): ?string
    {
        return $this->cancellationAmount;
    }

    public function setCancellationAmount(?string $cancellationAmount): self
    {
        $this->cancellationAmount = $cancellationAmount;

        return $this;
    }

    /**
     * @return CancellationItem[]
     */
    public function getCancellationItems(): array
    {
        return $this->cancellationItems;
    }

    /**
     * @param CancellationItem[] $cancellationItems
     */
    public function setCancellationItems(array $cancellationItems): self
    {
        $this->cancellationItems = $cancellationItems;

        return $this;
    }

    public function getCancellationNo(): ?string
    {
        return $this->cancellationNo;
    }

    public function setCancellationNo(?string $cancellationNo): self
    {
        $this->cancellationNo = $cancellationNo;

        return $this;
    }
}
