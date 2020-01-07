<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Type;

class CancellationItem
{
    use OrderItemTrait;

    /** @var null|string */
    public $cancellationNumber;
}
