<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Type;

class Order
{
    use OrderSummaryTrait;

    /** @var null|string */
    public $number;
}
