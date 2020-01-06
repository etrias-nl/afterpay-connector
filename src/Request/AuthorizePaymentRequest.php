<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Request;

use Etrias\AfterPayConnector\Type\CheckoutCustomer;
use Etrias\AfterPayConnector\Type\Order;
use Etrias\AfterPayConnector\Type\Payment;

class AuthorizePaymentRequest
{
    /** @var null|Payment */
    public $payment;

    /** @var null|CheckoutCustomer */
    public $customer;

    /** @var null|CheckoutCustomer */
    public $deliveryCustomer;

    /** @var null|string */
    public $merchantId;

    /** @var null|Order */
    public $order;

    /** @var null|string */
    public $ourReference;

    /** @var null|string */
    public $yourReference;

    public static function forInvoice(): self
    {
        $request = new self();
        $request->payment = new Payment();
        $request->payment->type = Payment::TYPE_INVOICE;

        return $request;
    }
}
