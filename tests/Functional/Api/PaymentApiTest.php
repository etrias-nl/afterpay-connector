<?php

declare(strict_types=1);

namespace Tests\Etrias\AfterPayConnector\Functional\Api;

use Etrias\AfterPayConnector\Api\PaymentApi;
use Etrias\AfterPayConnector\Request\AuthorizePaymentRequest;
use Etrias\AfterPayConnector\Response\AuthorizePaymentResponse;
use Etrias\AfterPayConnector\Type\Address;
use Etrias\AfterPayConnector\Type\CheckoutCustomer;
use Etrias\AfterPayConnector\Type\Order;
use Etrias\AfterPayConnector\Type\OrderItem;

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
        $request->customer = CheckoutCustomer::forPerson('john.doe@domain.test')
            ->withName(CheckoutCustomer::SALUTATION_MR, 'John', 'Doe 😁')
            ->withBirthDate(28, 7, 1987)
        ;
        $request->customer->address = Address::forPlace('NL', '1111AA', 'Test stad 😁')
            ->withStreet('Straatnaam 😁', '1', 'A')
        ;
        $request->order = Order::forItems('TEST-'.bin2hex(random_bytes(10)), [
            OrderItem::forProduct('A', 'Product A', 1)
                ->withPrice(2, 1)
                ->withVat(1, 21),
            OrderItem::forProduct('B', 'Product B 😁', 3)
                ->withPrice(3.5, 2.25)
                ->withVat(1, 6),
        ]);

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
