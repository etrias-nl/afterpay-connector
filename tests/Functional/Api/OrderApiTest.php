<?php

declare(strict_types=1);

namespace Tests\Etrias\AfterPayConnector\Functional\Api;

use Etrias\AfterPayConnector\Api\OrderApi;
use Etrias\AfterPayConnector\Request\CaptureRequest;
use Etrias\AfterPayConnector\Request\VoidAuthorizationRequest;

/**
 * @internal
 */
final class OrderApiTest extends ApiTestCase
{
    /** @var OrderApi */
    protected $api;

    protected function setUp(): void
    {
        parent::setUp();

        $this->api = new OrderApi($this->client, $this->serializer);
    }

    public function testCapturePayment(): void
    {
        $this->checkout($orderNumber = TestData::orderNumber());

        $request = new CaptureRequest();
        $request->orderDetails = TestData::orderSummary();

        $response = $this->api->capturePayment($orderNumber, $request);

        self::assertSame('38', $response->authorizedAmount);
        self::assertSame('38', $response->capturedAmount);
        self::assertNotEmpty($response->captureNumber);
        self::assertSame('0', $response->remainingAuthorizedAmount);
    }

    public function testVoidAuthorization(): void
    {
        $this->checkout($orderNumber = TestData::orderNumber());

        $request = new VoidAuthorizationRequest();
        $request->cancellationDetails = TestData::orderSummary();

        $response = $this->api->voidAuthorization($orderNumber, $request);

        self::assertSame('0', $response->remainingAuthorizedAmount);
        self::assertSame('38', $response->totalAuthorizedAmount);
        self::assertSame('0', $response->totalCapturedAmount);
    }
}
