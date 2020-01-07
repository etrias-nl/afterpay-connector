<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Request;

use Etrias\AfterPayConnector\Type\RefundOrderItem;
use Etrias\AfterPayConnector\Type\RefundType;

class RefundOrderRequest
{
    /** @var null|string */
    public $captureNumber;

    /** @var RefundOrderItem[] */
    public $items = [];

    /** @var null|string */
    public $creditNoteNumber;

    /** @var null|string */
    public $merchantId;

    /** @var null|string */
    public $refundType;

    public static function forRefund(string $captureNumber): self
    {
        $request = new self();
        $request->captureNumber = $captureNumber;
        $request->refundType = RefundType::REFUND;

        return $request;
    }

    public static function forReturn(string $captureNumber): self
    {
        $request = new self();
        $request->captureNumber = $captureNumber;
        $request->refundType = RefundType::RETURN;

        return $request;
    }

    public function withItems(RefundOrderItem ...$items)
    {
        $this->items = $items;

        return $this;
    }
}
