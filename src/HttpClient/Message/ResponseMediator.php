<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\HttpClient\Message;

use Psr\Http\Message\ResponseInterface;

class ResponseMediator
{
    public static function getData(ResponseInterface $response): array
    {
        $body = $response->getBody()->getContents();

        if (0 === strpos($response->getHeaderLine('Content-Type'), 'application/json')) {
            $content = json_decode($body, true);

            if (JSON_ERROR_NONE === json_last_error() && \is_array($content)) {
                return $content;
            }
        }

        return [];
    }
}
