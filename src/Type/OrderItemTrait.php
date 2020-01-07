<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Type;

trait OrderItemTrait
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
        $object = new self();
        $object->productId = $productId;
        $object->description = $description;
        $object->quantity = $quantity;

        return $object;
    }

    /**
     * @param null|float|int|string $netUnitPrice
     * @param null|float|int|string $vatAmount
     * @param null|float|int|string $vatPercent
     */
    public function withPrice($netUnitPrice, $vatAmount, $vatPercent): self
    {
        $this->netUnitPrice = $netUnitPrice;
        $this->vatAmount = $vatAmount;
        $this->vatPercent = $vatPercent;
        $this->grossUnitPrice = $netUnitPrice;
        if (null !== $this->grossUnitPrice) {
            $this->grossUnitPrice += $vatAmount ?? 0;
        } elseif (null !== $vatAmount) {
            $this->grossUnitPrice = $vatAmount;
        }

        return $this;
    }
}
