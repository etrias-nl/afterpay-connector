<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Request;

class UpdateCustomerRequest
{
    public const DISTRIBUTION_TYPE_PAPER = 'Paper';
    public const DISTRIBUTION_TYPE_EMAIL = 'Email';
    public const DISTRIBUTION_TYPE_SMS = 'Sms';

    /** @var null|string */
    protected $distributionType;

    /** @var null|string */
    protected $email;

    /** @var null|string */
    protected $mobilePhone;

    public function getDistributionType(): ?string
    {
        return $this->distributionType;
    }

    public function setDistributionType(?string $distributionType): self
    {
        $this->distributionType = $distributionType;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMobilePhone(): ?string
    {
        return $this->mobilePhone;
    }

    public function setMobilePhone(?string $mobilePhone): self
    {
        $this->mobilePhone = $mobilePhone;

        return $this;
    }
}
