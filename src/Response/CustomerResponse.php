<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Response;

use Etrias\AfterPayConnector\Type\Address;

class CustomerResponse
{
    /** @var null|string */
    public $customerAccountId;

    /** @var null|string */
    public $customerNumber;

    /** @var null|string */
    public $firstName;

    /** @var null|string */
    public $lastName;

    /** @var Address[] */
    public $addressList = [];
}
