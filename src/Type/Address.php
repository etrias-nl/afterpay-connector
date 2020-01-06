<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Type;

class Address
{
    /** @var null|string */
    public $countryCode;

    /** @var null|string */
    public $postalCode;

    /** @var null|string */
    public $postalPlace;

    /** @var null|string */
    public $street;

    /** @var null|string */
    public $streetNumber;

    /** @var null|string */
    public $streetNumberAdditional;
}
