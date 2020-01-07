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

    public static function forPlace(?string $countryCode, ?string $postalCode, ?string $postalPlace): self
    {
        $address = new self();
        $address->countryCode = $countryCode;
        $address->postalCode = $postalCode;
        $address->postalPlace = $postalPlace;

        return $address;
    }

    public function withStreet(?string $street, ?string $streetNumber, ?string $streetNumberAdditional): self
    {
        $this->street = $street;
        $this->streetNumber = $streetNumber;
        $this->streetNumberAdditional = $streetNumberAdditional;

        return $this;
    }
}
