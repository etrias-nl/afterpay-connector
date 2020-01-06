<?php

declare(strict_types=1);

namespace Tests\Etrias\AfterPayConnector\Functional\Api;

use Etrias\AfterPayConnector\HttpClient\Plugin\Authentication;
use Http\Client\Common\HttpMethodsClient;
use Http\Client\Common\Plugin\BaseUriPlugin;
use Http\Client\Common\Plugin\ErrorPlugin;
use Http\Client\Common\PluginClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;

abstract class ApiTestCase extends TestCase
{
    /** @var ClientInterface */
    protected $client;

    /** @var SerializerInterface */
    protected $serializer;

    protected function setUp(): void
    {
        $this->client = new HttpMethodsClient(
            new PluginClient(HttpClientDiscovery::find(), [
                new ErrorPlugin(['only_server_exception' => true]),
                new BaseUriPlugin(Psr17FactoryDiscovery::findUrlFactory()->createUri(getenv('AFTERPAY_API_BASE_URI'))),
                new Authentication(getenv('AFTERPAY_API_KEY')),
            ]),
            new GuzzleMessageFactory()
        );

        $this->serializer = SerializerBuilder::create()
            ->setCacheDir(sys_get_temp_dir().'/jms-cache')
            ->addMetadataDir(__DIR__.'/../../../src/Serializer/Metadata', 'Etrias\AfterPayConnector')
            ->addDefaultDeserializationVisitors()
            ->addDefaultSerializationVisitors()
            ->addDefaultHandlers()
            ->build()
        ;
    }
}
