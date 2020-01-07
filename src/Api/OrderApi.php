<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Api;

use Etrias\AfterPayConnector\Request\CaptureRequest;
use Etrias\AfterPayConnector\Request\RefundOrderRequest;
use Etrias\AfterPayConnector\Request\VoidAuthorizationRequest;
use Etrias\AfterPayConnector\Response\CaptureResponse;
use Etrias\AfterPayConnector\Response\GetOrderResponse;
use Etrias\AfterPayConnector\Response\RefundOrderResponse;
use Etrias\AfterPayConnector\Response\VoidAuthorizationResponse;

class OrderApi extends AbstractApi
{
    public function capturePayment(string $orderNumber, CaptureRequest $request): CaptureResponse
    {
        $uri = $this->uriFactory->createUri(\GuzzleHttp\uri_template('/orders/{orderNumber}/captures', compact('orderNumber')));
        $response = $this->postJson($uri, $request);

        return $this->deserialize($response, CaptureResponse::class);
    }

    public function voidAuthorization(string $orderNumber, VoidAuthorizationRequest $request): VoidAuthorizationResponse
    {
        $uri = $this->uriFactory->createUri(\GuzzleHttp\uri_template('/orders/{orderNumber}/voids', compact('orderNumber')));
        $response = $this->postJson($uri, $request);

        return $this->deserialize($response, VoidAuthorizationResponse::class);
    }

    public function refundPayment(string $orderNumber, RefundOrderRequest $request): RefundOrderResponse
    {
        $uri = $this->uriFactory->createUri(\GuzzleHttp\uri_template('/orders/{orderNumber}/refunds', compact('orderNumber')));
        $response = $this->postJson($uri, $request);

        return $this->deserialize($response, RefundOrderResponse::class);
    }

    public function getOrder(string $orderNumber): GetOrderResponse
    {
        $uri = $this->uriFactory->createUri(\GuzzleHttp\uri_template('/orders/{orderNumber}', compact('orderNumber')));
        $response = $this->getJson($uri);

        return $this->deserialize($response, GetOrderResponse::class);
    }
}
