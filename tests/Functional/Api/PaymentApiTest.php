<?php

declare(strict_types=1);

namespace Tests\Etrias\AfterPayConnector\Functional\Api;

use Etrias\AfterPayConnector\Api\PaymentApi;
use Etrias\AfterPayConnector\Request\AuthorizePaymentRequest;

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
        $response = $this->api->authorize($request);

        var_dump($response);
    }
}
