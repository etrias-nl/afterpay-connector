<?php

declare(strict_types=1);

namespace Tests\Etrias\AfterPayConnector\Functional\Api;

use Etrias\AfterPayConnector\Api\CheckoutApi;
use Etrias\AfterPayConnector\HttpClient\Plugin\Authentication;
use Etrias\AfterPayConnector\HttpClient\Plugin\ErrorHandler;
use Etrias\AfterPayConnector\Request\AuthorizePaymentRequest;
use Http\Client\Common\HttpMethodsClient;
use Http\Client\Common\HttpMethodsClientInterface;
use Http\Client\Common\Plugin\BaseUriPlugin;
use Http\Client\Common\Plugin\ErrorPlugin;
use Http\Client\Common\PluginClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;
use PHPUnit\Framework\TestCase;

abstract class ApiTestCase extends TestCase
{
    /** @var SerializerInterface */
    protected $serializer;

    /** @var HttpMethodsClientInterface */
    protected $client;

    protected function setUp(): void
    {
        $this->serializer = SerializerBuilder::create()
            ->setCacheDir(sys_get_temp_dir().'/jms-cache')
            ->setPropertyNamingStrategy(new IdenticalPropertyNamingStrategy())
            ->addMetadataDir(__DIR__.'/../../../src/Serializer/Metadata', 'Etrias\AfterPayConnector')
            ->addDefaultDeserializationVisitors()
            ->addDefaultSerializationVisitors()
            ->addDefaultHandlers()
            ->build()
        ;

        $this->client = new HttpMethodsClient(
            new PluginClient(HttpClientDiscovery::find(), [
                new ErrorPlugin(['only_server_exception' => true]),
                new ErrorHandler($this->serializer),
                new BaseUriPlugin(Psr17FactoryDiscovery::findUrlFactory()->createUri(getenv('AFTERPAY_API_BASE_URI'))),
                new Authentication(getenv('AFTERPAY_API_KEY')),
            ]),
            new GuzzleMessageFactory()
        );
    }

    protected function checkout(string $orderNumber): string
    {
        $request = AuthorizePaymentRequest::forInvoice();
        $request->customer = TestData::checkoutCustomer();
        $request->order = TestData::order($orderNumber);

        return (new CheckoutApi($this->client, $this->serializer))->authorizePayment($request)->checkoutId;
    }
}
