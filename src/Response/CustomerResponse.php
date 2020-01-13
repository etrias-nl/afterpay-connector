<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Response;

use Etrias\AfterPayConnector\Type\Address;

class CustomerResponse
{
    /** @var null|string */
    protected $customerAccountId;

    /** @var null|string */
    protected $customerNumber;

    /** @var null|string */
    protected $firstName;

    /** @var null|string */
    protected $lastName;

    /** @var Address[] */
    protected $addressList = [];

    public function getCustomerAccountId(): ?string
    {
        return $this->customerAccountId;
    }

    public function setCustomerAccountId(?string $customerAccountId): self
    {
        $this->customerAccountId = $customerAccountId;

        return $this;
    }

    public function getCustomerNumber(): ?string
    {
        return $this->customerNumber;
    }

    public function setCustomerNumber(?string $customerNumber): self
    {
        $this->customerNumber = $customerNumber;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return Address[]
     */
    public function getAddressList(): array
    {
        return $this->addressList;
    }

    /**
     * @param Address[] $addressList
     */
    public function setAddressList(array $addressList): self
    {
        $this->addressList = $addressList;

        return $this;
    }
}
