<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Api;

use Etrias\AfterPayConnector\Request\CaptureRequest;
use Etrias\AfterPayConnector\Request\RefundOrderRequest;
use Etrias\AfterPayConnector\Request\VoidAuthorizationRequest;
use Etrias\AfterPayConnector\Response\CaptureResponse;
use Etrias\AfterPayConnector\Response\RefundOrderResponse;
use Etrias\AfterPayConnector\Response\VoidAuthorizationResponse;

class OrderApi extends AbstractApi
{
    public function capturePayment(string $orderNumber, CaptureRequest $request): CaptureResponse
    {
        $uri = $this->uriFactory->createUri(\GuzzleHttp\uri_template('/orders/{orderNumber}/captures', compact('orderNumber')));
        $response = $this->postJsonRequest($uri, $request);

        return $this->fromJsonResponse($response, CaptureResponse::class);
    }

    public function voidAuthorization(string $orderNumber, VoidAuthorizationRequest $request): VoidAuthorizationResponse
    {
        $uri = $this->uriFactory->createUri(\GuzzleHttp\uri_template('/orders/{orderNumber}/voids', compact('orderNumber')));
        $response = $this->postJsonRequest($uri, $request);

        return $this->fromJsonResponse($response, VoidAuthorizationResponse::class);
    }

    public function refundPayment(string $orderNumber, RefundOrderRequest $request): RefundOrderResponse
    {
        $uri = $this->uriFactory->createUri(\GuzzleHttp\uri_template('/orders/{orderNumber}/refunds', compact('orderNumber')));
        $response = $this->postJsonRequest($uri, $request);

        return $this->fromJsonResponse($response, RefundOrderResponse::class);
    }
}
