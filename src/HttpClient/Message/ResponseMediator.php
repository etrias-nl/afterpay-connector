<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\HttpClient\Message;

use Psr\Http\Message\ResponseInterface;

class ResponseMediator
{
    public static function getData(ResponseInterface $response): array
    {
        if (0 === strpos($response->getHeaderLine('Content-Type'), 'application/json')) {
            $content = \GuzzleHttp\json_decode((string) $response->getBody(), true);

            if (\is_array($content)) {
                return $content;
            }
        }

        return [];
    }
}
