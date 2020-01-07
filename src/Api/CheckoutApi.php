<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Api;

use Etrias\AfterPayConnector\Request\AuthorizePaymentRequest;
use Etrias\AfterPayConnector\Request\AvailablePaymentMethodsRequest;
use Etrias\AfterPayConnector\Response\AuthorizePaymentResponse;
use Etrias\AfterPayConnector\Response\AvailablePaymentMethodsResponse;

class CheckoutApi extends AbstractApi
{
    public function authorizePayment(AuthorizePaymentRequest $request): AuthorizePaymentResponse
    {
        $uri = $this->uriFactory->createUri('/checkout/authorize');
        $response = $this->postJson($uri, $request);

        return $this->deserialize($response, AuthorizePaymentResponse::class);
    }

    public function getAvailablePaymentMethods(AvailablePaymentMethodsRequest $request): AvailablePaymentMethodsResponse
    {
        $uri = $this->uriFactory->createUri('/checkout/payment-methods');
        $response = $this->postJson($uri, $request);

        return $this->deserialize($response, AvailablePaymentMethodsResponse::class);
    }
}
