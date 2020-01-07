<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\HttpClient\Plugin;

use Etrias\AfterPayConnector\Exception\AfterPayException;
use Etrias\AfterPayConnector\Type\ResponseMessage;
use Http\Client\Common\Plugin;
use Http\Promise\Promise;
use JMS\Serializer\Exception\RuntimeException;
use JMS\Serializer\SerializerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ErrorHandler implements Plugin
{
    protected const JSON_FORMAT = 'json';

    /** @var SerializerInterface */
    protected $serializer;

    public function __construct(
        SerializerInterface $serializer
    ) {
        $this->serializer = $serializer;
    }

    /**
     * {@inheritdoc}
     */
    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        return $next($request)->then(function (ResponseInterface $response) {
            $status = $response->getStatusCode();

            if ($status >= 400 && $status < 500) {
                $body = (string) $response->getBody();

                if (!preg_match('/\bjson\b/i', $response->getHeaderLine('Content-Type'))) {
                    throw new AfterPayException($body);
                }

                try {
                    /** @var ResponseMessage[] $data */
                    $data = $this->serializer->deserialize($body, 'array<'.ResponseMessage::class.'>', self::JSON_FORMAT);
                    if (!$data) {
                        throw new AfterPayException('An unknown error occurred.');
                    }
                    /** @var ResponseMessage $message */
                    $message = reset($data);
                } catch (RuntimeException $e) {
                    /** @var ResponseMessage $message */
                    $message = $this->serializer->deserialize($body, ResponseMessage::class, self::JSON_FORMAT);
                }

                throw new AfterPayException($message->toExceptionMessage());
            }

            return $response;
        });
    }
}
