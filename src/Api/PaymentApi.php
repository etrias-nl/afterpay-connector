<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Api;

use Etrias\AfterPayConnector\Request\AuthorizePaymentRequest;
use Etrias\AfterPayConnector\Response\AuthorizePaymentResponse;

class PaymentApi extends AbstractApi
{
    public function authorize(AuthorizePaymentRequest $request): AuthorizePaymentResponse
    {
        $uri = $this->uriFactory->createUri('/checkout/authorize');
        $response = $this->postJsonRequest($uri, $request);

        return $this->fromJsonResponse($response, AuthorizePaymentResponse::class);
    }
}
