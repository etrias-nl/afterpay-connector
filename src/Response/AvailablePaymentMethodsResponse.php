<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Response;

use Etrias\AfterPayConnector\Type\PaymentMethod;

class AvailablePaymentMethodsResponse
{
    use AuthorizeResponseTrait;

    /** @var PaymentMethod[] */
    public $paymentMethods = [];
}
