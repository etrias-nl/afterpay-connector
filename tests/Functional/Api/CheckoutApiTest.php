<?php

declare(strict_types=1);

namespace Tests\Etrias\AfterPayConnector\Functional\Api;

use Etrias\AfterPayConnector\Request\AuthorizePaymentRequest;
use Etrias\AfterPayConnector\Request\AvailablePaymentMethodsRequest;
use Etrias\AfterPayConnector\Type\Outcome;

/**
 * @internal
 */
final class CheckoutApiTest extends ApiTestCase
{
    public function testAuthorizePayment(): void
    {
        $request = AuthorizePaymentRequest::forInvoice();
        $request->customer = TestData::checkoutCustomer();
        $request->order = TestData::order();

        $response = $this->checkoutApi->authorizePayment($request);

        self::assertSame(Outcome::ACCEPTED, $response->outcome);
        self::assertSame('John', $response->customer->firstName);
        self::assertSame('Doe 😁', $response->customer->lastName);
        self::assertSame('NL', $response->customer->addressList[0]->countryCode);
        self::assertNull($response->deliveryCustomer);
        self::assertStringMatchesFormat('%x-%x-%x-%x-%x', $response->checkoutId);
        self::assertStringMatchesFormat('%x-%x-%x-%x-%x', $response->reservationId);
    }

    public function testAvailablePaymentMethods(): void
    {
        $request = new AvailablePaymentMethodsRequest();
        $request->customer = TestData::checkoutCustomer();
        $request->order = TestData::order();

        $response = $this->checkoutApi->getAvailablePaymentMethods($request);

        self::assertSame(Outcome::ACCEPTED, $response->outcome);
        self::assertSame('John', $response->customer->firstName);
        self::assertSame('Doe 😁', $response->customer->lastName);
        self::assertSame('NL', $response->customer->addressList[0]->countryCode);
        self::assertNull($response->deliveryCustomer);
        self::assertStringMatchesFormat('%x-%x-%x-%x-%x', $response->checkoutId);
        self::assertIsString($response->paymentMethods[0]->title);
    }
}
