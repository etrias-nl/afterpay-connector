<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Type;

class OrderItem
{
    /** @var null|string */
    public $description;

    /** @var null|float|int|string */
    public $grossUnitPrice;

    /** @var null|float|int|string */
    public $netUnitPrice;

    /** @var null|string */
    public $productId;

    /** @var null|int|string */
    public $quantity;

    /** @var null|float|int|string */
    public $vatAmount;

    /** @var null|float|int|string */
    public $vatPercent;

    public static function forProduct(string $productId, string $description, int $quantity = 1): self
    {
        $item = new self();
        $item->productId = $productId;
        $item->description = $description;
        $item->quantity = $quantity;

        return $item;
    }

    /**
     * @param null|float|int|string $grossUnitPrice
     * @param null|float|int|string $netUnitPrice
     */
    public function withPrice($grossUnitPrice, $netUnitPrice): self
    {
        $this->grossUnitPrice = $grossUnitPrice;
        $this->netUnitPrice = $netUnitPrice;

        return $this;
    }

    /**
     * @param null|float|int|string $amount
     * @param null|float|int|string $percent
     */
    public function withVat($amount, $percent): self
    {
        $this->vatAmount = $amount;
        $this->vatPercent = $percent;

        return $this;
    }
}
