<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Api;

use Etrias\AfterPayConnector\Request\UpdateCustomerRequest;
use GuzzleHttp\UriTemplate\UriTemplate;

class Customers extends AbstractApi
{
    public function updateCustomer(string $customerNumber, UpdateCustomerRequest $request): void
    {
        $uri = $this->uriFactory->createUri(UriTemplate::expand('/customers/{customerNumber}/updateCustomer', compact('customerNumber')));

        $this->patchJson($uri, $request);
    }
}
