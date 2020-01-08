<?php

declare(strict_types=1);

namespace Tests\Etrias\AfterPayConnector\Functional\Api;

use Etrias\AfterPayConnector\Api\Orders;
use Etrias\AfterPayConnector\HttpClient\Plugin\Authentication;
use Etrias\AfterPayConnector\HttpClient\Plugin\ErrorHandler;
use Etrias\AfterPayConnector\Request\AuthorizePaymentRequest;
use Etrias\AfterPayConnector\Request\CaptureRequest;
use Etrias\AfterPayConnector\Request\RefundOrderRequest;
use Etrias\AfterPayConnector\Request\VoidAuthorizationRequest;
use Http\Client\Common\HttpMethodsClient;
use Http\Client\Common\Plugin\BaseUriPlugin;
use Http\Client\Common\Plugin\ErrorPlugin;
use Http\Client\Common\PluginClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\SerializerBuilder;
use PHPUnit\Framework\TestCase;

abstract class ApiTestCase extends TestCase
{
    /** @var Orders */
    protected $orders;

    protected function setUp(): void
    {
        $serializer = SerializerBuilder::create()
            ->setCacheDir(sys_get_temp_dir().'/jms-cache')
            ->setPropertyNamingStrategy(new IdenticalPropertyNamingStrategy())
            ->addMetadataDir(__DIR__.'/../../../src/Serializer/Metadata', 'Etrias\AfterPayConnector')
            ->addDefaultDeserializationVisitors()
            ->addDefaultSerializationVisitors()
            ->addDefaultHandlers()
            ->build()
        ;
        $client = new HttpMethodsClient(
            new PluginClient(HttpClientDiscovery::find(), [
                new ErrorPlugin(['only_server_exception' => true]),
                new ErrorHandler($serializer),
                new BaseUriPlugin(Psr17FactoryDiscovery::findUrlFactory()->createUri(getenv('AFTERPAY_API_BASE_URI'))),
                new Authentication(getenv('AFTERPAY_API_KEY')),
            ]),
            new GuzzleMessageFactory()
        );

        $this->orders = new Orders($client, $serializer);
    }

    protected function checkout(string $orderNumber): string
    {
        $request = AuthorizePaymentRequest::forInvoice();
        $request->customer = TestData::checkoutCustomer();
        $request->order = TestData::order($orderNumber);

        return $this->orders->authorizePayment($request)->checkoutId;
    }

    protected function cancel(string $orderNumber): void
    {
        $request = new VoidAuthorizationRequest();
        $request->cancellationDetails = TestData::orderSummary();

        $this->orders->voidAuthorization($orderNumber, $request);
    }

    protected function capture(string $orderNumber): string
    {
        $request = new CaptureRequest();
        $request->orderDetails = TestData::orderSummary();

        return $this->orders->capturePayment($orderNumber, $request)->captureNumber;
    }

    /**
     * @return string[]
     */
    protected function refund(string $orderNumber, string $captureNumber): array
    {
        $request = RefundOrderRequest::forRefund($captureNumber)
            ->withItems(TestData::refundOrderItem())
        ;

        return $this->orders->refundPayment($orderNumber, $request)->refundNumbers;
    }
}
