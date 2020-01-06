<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Api;

use Etrias\AfterPayConnector\Request\AuthorizePaymentRequest;
use Etrias\AfterPayConnector\Response\AuthorizePaymentResponse;

class PaymentApi extends AbstractApi
{
    public function authorize(AuthorizePaymentRequest $request): AuthorizePaymentResponse
    {
        return new AuthorizePaymentResponse();
    }
}
