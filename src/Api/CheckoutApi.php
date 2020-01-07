<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Api;

use Etrias\AfterPayConnector\Request\AuthorizePaymentRequest;
use Etrias\AfterPayConnector\Request\AvailablePaymentMethodsRequest;
use Etrias\AfterPayConnector\Response\AuthorizePaymentResponse;
use Etrias\AfterPayConnector\Response\AvailablePaymentMethodsResponse;

class CheckoutApi extends AbstractApi
{
    public function authorize(AuthorizePaymentRequest $request): AuthorizePaymentResponse
    {
        $uri = $this->uriFactory->createUri('/checkout/authorize');
        $response = $this->postJsonRequest($uri, $request);

        return $this->fromJsonResponse($response, AuthorizePaymentResponse::class);
    }

    public function getAvailableMethods(AvailablePaymentMethodsRequest $request): AvailablePaymentMethodsResponse
    {
        $uri = $this->uriFactory->createUri('/checkout/payment-methods');
        $response = $this->postJsonRequest($uri, $request);

        return $this->fromJsonResponse($response, AvailablePaymentMethodsResponse::class);
    }
}
