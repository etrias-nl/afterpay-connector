<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Type;

trait OrderSummaryTrait
{
    /** @var null|float|int|string */
    protected $totalGrossAmount;

    /** @var null|float|int|string */
    protected $totalNetAmount;

    /** @var null|string */
    protected $currency;

    /** @var OrderItem[] */
    protected $items = [];

    /**
     * @return null|float|int|string
     */
    public function getTotalGrossAmount()
    {
        return $this->totalGrossAmount;
    }

    /**
     * @param null|float|int|string $totalGrossAmount
     *
     * @return self
     */
    public function setTotalGrossAmount($totalGrossAmount)
    {
        $this->totalGrossAmount = $totalGrossAmount;

        return $this;
    }

    /**
     * @return null|float|int|string
     */
    public function getTotalNetAmount()
    {
        return $this->totalNetAmount;
    }

    /**
     * @param null|float|int|string $totalNetAmount
     *
     * @return self
     */
    public function setTotalNetAmount($totalNetAmount)
    {
        $this->totalNetAmount = $totalNetAmount;

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

    /**
     * @return OrderItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param OrderItem[] $items
     */
    public function setItems(array $items): self
    {
        $this->items = $items;

        return $this;
    }
}
