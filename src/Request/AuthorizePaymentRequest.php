<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Request;

use Etrias\AfterPayConnector\Type\Payment;

class AuthorizePaymentRequest
{
    use AuthorizeTrait;

    /** @var null|Payment */
    public $payment;

    /** @var null|string */
    public $checkoutId;

    /** @var null|string */
    public $merchantId;

    public static function forInvoice(): self
    {
        $request = new self();
        $request->payment = new Payment();
        $request->payment->type = Payment::TYPE_INVOICE;

        return $request;
    }
}
