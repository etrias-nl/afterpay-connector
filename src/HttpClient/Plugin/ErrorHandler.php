<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\HttpClient\Plugin;

use Etrias\AfterPayConnector\Exception\AfterPayException;
use Etrias\AfterPayConnector\HttpClient\Message\ResponseMediator;
use Http\Client\Common\Plugin;
use Http\Promise\Promise;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ErrorHandler implements Plugin
{
    protected const ERROR_TYPES = ['BusinessError'];

    /**
     * {@inheritdoc}
     */
    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        return $next($request)->then(function (ResponseInterface $response) {
            if ($response->getStatusCode() < 500) {
                $data = ResponseMediator::getData($response);

                if (isset($data[0]['type']) && \in_array($data[0]['type'], self::ERROR_TYPES, true)) {
                    throw new AfterPayException(self::getErrorMessage($data[0]));
                }
            }

            return $response;
        });
    }

    protected static function getErrorMessage(array $data): string
    {
        $message = $data['message'] ?? $data['customerFacingMessage'] ?? 'Unknown error.';
        $message .= ' (code='.($data['code'] ?? 'unknown').', action_code='.($data['actionCode'] ?? 'unknown').')';

        if (isset($data['fieldReference'])) {
            return 'Error for field "'.$data['fieldReference'].'": '.$message;
        }

        return $message;
    }
}
