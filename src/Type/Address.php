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
        $object = new self();
        $object->countryCode = $countryCode;
        $object->postalCode = $postalCode;
        $object->postalPlace = $postalPlace;

        return $object;
    }

    public function withStreet(?string $street, ?string $streetNumber, ?string $streetNumberAdditional): self
    {
        $this->street = $street;
        $this->streetNumber = $streetNumber;
        $this->streetNumberAdditional = $streetNumberAdditional;

        return $this;
    }
}
