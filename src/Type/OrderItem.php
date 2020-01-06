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
}
