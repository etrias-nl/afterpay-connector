<?php

declare(strict_types=1);

namespace Tests\Etrias\AfterPayConnector\Functional\Api;

use Etrias\AfterPayConnector\Api\PaymentApi;
use Etrias\AfterPayConnector\Request\AuthorizePaymentRequest;
use Etrias\AfterPayConnector\Response\AuthorizePaymentResponse;

/**
 * @internal
 */
final class PaymentApiTest extends ApiTestCase
{
    /** @var PaymentApi */
    protected $api;

    protected function setUp(): void
    {
        parent::setUp();

        $this->api = new PaymentApi($this->client, $this->serializer);
    }

    public function testAuthorize(): void
    {
        $request = AuthorizePaymentRequest::forInvoice();
        $request->customer = TestData::checkoutCustomer();
        $request->order = TestData::order();

        $response = $this->api->authorize($request);

        self::assertSame(AuthorizePaymentResponse::OUTCOME_ACCEPTED, $response->outcome);
        self::assertSame('John', $response->customer->firstName);
        self::assertSame('Doe 😁', $response->customer->lastName);
        self::assertSame('NL', $response->customer->addressList[0]->countryCode);
        self::assertNull($response->deliveryCustomer);
        self::assertStringMatchesFormat('%x-%x-%x-%x-%x', $response->checkoutId);
        self::assertStringMatchesFormat('%x-%x-%x-%x-%x', $response->reservationId);
    }
}
