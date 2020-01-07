<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Type;

class RefundOrderItem
{
    use OrderItemTrait;

    /** @var null|string */
    public $refundType;
}
