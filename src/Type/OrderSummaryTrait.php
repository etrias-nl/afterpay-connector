<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Type;

trait OrderSummaryTrait
{
    /** @var null|float|int|string */
    public $totalGrossAmount;

    /** @var null|float|int|string */
    public $totalNetAmount;

    /** @var null|string */
    public $currency;

    /** @var OrderItem[] */
    public $items = [];

    /**
     * @param OrderItem[] $items
     */
    public static function forItems(iterable $items): self
    {
        $object = new self();
        $object->totalGrossAmount = .0;
        $object->totalNetAmount = .0;

        foreach ($items as $item) {
            $object->items[] = $item;
            $object->totalGrossAmount += $item->grossUnitPrice * $item->quantity;
            $object->totalNetAmount += $item->netUnitPrice * $item->quantity;
        }

        return $object;
    }
}
