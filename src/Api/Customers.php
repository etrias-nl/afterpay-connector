<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Api;

use Etrias\AfterPayConnector\Request\UpdateCustomerRequest;

class Customers extends AbstractApi
{
    public function updateCustomer(string $customerNumber, UpdateCustomerRequest $request): void
    {
        $uri = $this->uriFactory->createUri(\GuzzleHttp\uri_template('/customers/{customerNumber}/updateCustomer', compact('customerNumber')));

        $this->postJson($uri, $request);
    }
}
