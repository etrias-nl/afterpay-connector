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
        $order = new self();
        $order->totalGrossAmount = .0;
        $order->totalNetAmount = .0;

        foreach ($items as $item) {
            $order->items[] = $item;
            $order->totalGrossAmount += $item->grossUnitPrice * $item->quantity;
            $order->totalNetAmount += $item->netUnitPrice * $item->quantity;
        }

        return $order;
    }
}
