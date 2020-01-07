<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Type;

class Cancellation
{
    /** @var null|string */
    public $cancellationAmount;

    /** @var CancellationItem[] */
    public $cancellationItems = [];

    /** @var null|string */
    public $cancellationNo;
}
