<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Type;

class CustomerRisk
{
    /** @var null|string */
    protected $ipAddress;

    public function getIpAddress(): ?string
    {
        return $this->ipAddress;
    }

    public function setIpAddress(?string $ipAddress): self
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }
}
