<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Type;

class Order
{
    public const CURRENCY_EUR = 'EUR';
    public const CURRENCY_NOK = 'NOK';
    public const CURRENCY_SEK = 'SEK';
    public const CURRENCY_DKK = 'DKK';
    public const CURRENCY_CHF = 'CHF';

    /** @var null|float|int|string */
    public $totalGrossAmount;

    /** @var null|float|int|string */
    public $totalNetAmount;

    /** @var null|string */
    public $currency;

    /** @var OrderItem[] */
    public $items = [];

    /** @var null|string */
    public $number;

    /**
     * @param OrderItem[] $items
     */
    public static function forItems(string $number, iterable $items): self
    {
        $order = new self();
        $order->number = $number;
        $order->totalGrossAmount = .0;
        $order->totalNetAmount = .0;

        foreach ($order->items as $item) {
            $order->items[] = $item;
            $order->totalGrossAmount += $item->grossUnitPrice * $item->quantity;
            $order->totalNetAmount += $item->netUnitPrice * $item->quantity;
        }

        return $order;
    }
}
