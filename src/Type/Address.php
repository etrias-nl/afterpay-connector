<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Type;

class Address
{
    /** @var null|string */
    protected $countryCode;

    /** @var null|string */
    protected $postalCode;

    /** @var null|string */
    protected $postalPlace;

    /** @var null|string */
    protected $street;

    /** @var null|string */
    protected $streetNumber;

    /** @var null|string */
    protected $streetNumberAdditional;

    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    public function setCountryCode(?string $countryCode): self
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(?string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getPostalPlace(): ?string
    {
        return $this->postalPlace;
    }

    public function setPostalPlace(?string $postalPlace): self
    {
        $this->postalPlace = $postalPlace;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(?string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getStreetNumber(): ?string
    {
        return $this->streetNumber;
    }

    public function setStreetNumber(?string $streetNumber): self
    {
        $this->streetNumber = $streetNumber;

        return $this;
    }

    public function getStreetNumberAdditional(): ?string
    {
        return $this->streetNumberAdditional;
    }

    public function setStreetNumberAdditional(?string $streetNumberAdditional): self
    {
        $this->streetNumberAdditional = $streetNumberAdditional;

        return $this;
    }
}
