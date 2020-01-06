<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Type;

class Payment
{
    public const TYPE_INVOICE = 'Invoice';

    /** @var null|string */
    public $type;
}
