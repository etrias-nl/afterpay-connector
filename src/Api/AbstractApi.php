<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Api;

use Http\Client\Common\HttpMethodsClientInterface;
use Http\Discovery\Psr17FactoryDiscovery;
use JMS\Serializer\SerializerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;

abstract class AbstractApi
{
    protected const JSON_FORMAT = 'json';
    protected const JSON_CONTENT_TYPE = 'application/json';
    protected const JSON_ACCEPT_HEADERS = [
        'Accept' => self::JSON_CONTENT_TYPE,
        'Content-Type' => self::JSON_CONTENT_TYPE,
    ];

    /** @var HttpMethodsClientInterface */
    protected $client;

    /** @var SerializerInterface */
    protected $serializer;

    /** @var UriFactoryInterface */
    protected $uriFactory;

    public function __construct(
        HttpMethodsClientInterface $client,
        SerializerInterface $serializer,
        ?UriFactoryInterface $uriFactory = null
    ) {
        $this->client = $client;
        $this->serializer = $serializer;
        $this->uriFactory = $uriFactory ?? Psr17FactoryDiscovery::findUrlFactory();
    }

    protected function postJson(UriInterface $uri, object $data): ResponseInterface
    {
        return $this->client->post($uri, self::JSON_ACCEPT_HEADERS, $this->serializer->serialize($data, self::JSON_FORMAT));
    }

    protected function patchJson(UriInterface $uri, object $data): ResponseInterface
    {
        return $this->client->patch($uri, self::JSON_ACCEPT_HEADERS, $this->serializer->serialize($data, self::JSON_FORMAT));
    }

    protected function getJson(UriInterface $uri): ResponseInterface
    {
        return $this->client->get(
            $uri,
            [
                'Accept' => self::JSON_CONTENT_TYPE,
            ]
        );
    }

    protected function deserialize(ResponseInterface $response, string $type): object
    {
        return $this->serializer->deserialize((string) $response->getBody(), $type, self::JSON_FORMAT);
    }
}
