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
}
