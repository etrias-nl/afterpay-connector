<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Api;

use Http\Client\Common\HttpMethodsClientInterface;
use JMS\Serializer\SerializerInterface;
use Psr\Http\Client\ClientInterface;

abstract class AbstractApi
{
    protected const JSON_FORMAT = 'json';

    /** @var HttpMethodsClientInterface */
    protected $client;

    /** @var SerializerInterface */
    protected $serializer;

    public function __construct(
        ClientInterface $client,
        SerializerInterface $serializer
    ) {
        $this->client = $client;
        $this->serializer = $serializer;
    }

    public function toJson(object $data): string
    {
        return $this->serializer->serialize($data, self::JSON_FORMAT);
    }
}
