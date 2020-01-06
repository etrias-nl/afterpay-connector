<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\HttpClient\Plugin;

use Http\Client\Common\Plugin;
use Http\Promise\Promise;
use Psr\Http\Message\RequestInterface;

class Authentication implements Plugin
{
    protected const API_KEY_HEADER = 'X-Auth-Key';

    /** @var string */
    protected $apiKey;

    public function __construct(
        string $apiKey
    ) {
        $this->apiKey = $apiKey;
    }

    /**
     * {@inheritDoc}
     */
    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        return $next($request->withHeader(self::API_KEY_HEADER, $this->apiKey));
    }
}
