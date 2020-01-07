<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Api;

use Etrias\AfterPayConnector\Request\CaptureRequest;
use Etrias\AfterPayConnector\Response\CaptureResponse;

class OrderApi extends AbstractApi
{
    public function capturePayment(string $orderNumber, CaptureRequest $request): CaptureResponse
    {
        $uri = $this->uriFactory->createUri(\GuzzleHttp\uri_template('/orders/{orderNumber}/captures', compact('orderNumber')));
        $response = $this->postJsonRequest($uri, $request);

        return $this->fromJsonResponse($response, CaptureResponse::class);
    }
}
