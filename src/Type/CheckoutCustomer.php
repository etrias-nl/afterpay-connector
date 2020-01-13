<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Type;

class CheckoutCustomer
{
    public const CATEGORY_COMPANY = 'Company';
    public const CATEGORY_PERSON = 'Person';

    public const SALUTATION_MR = 'Mr';
    public const SALUTATION_MRS = 'Mrs';
    public const SALUTATION_MISS = 'Miss';

    /** @var null|string */
    protected $customerCategory;

    /** @var null|\DateTime */
    protected $birthDate;

    /** @var null|string */
    protected $email;

    /** @var null|string */
    protected $identificationNumber;

    /** @var null|CustomerRisk */
    protected $riskData;

    /** @var null|string */
    protected $salutation;

    /** @var null|Address */
    protected $address;

    /** @var null|string */
    protected $companyName;

    /** @var null|string */
    protected $customerNumber;

    /** @var null|string */
    protected $firstName;

    /** @var null|string */
    protected $lastName;

    /** @var null|string */
    protected $phone;

    public function getCustomerCategory(): ?string
    {
        return $this->customerCategory;
    }

    public function setCustomerCategory(?string $customerCategory): self
    {
        $this->customerCategory = $customerCategory;

        return $this;
    }

    public function getBirthDate(): ?\DateTime
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTime $birthDate): self
    {
        $this->birthDate = $birthDate;

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

    public function getIdentificationNumber(): ?string
    {
        return $this->identificationNumber;
    }

    public function setIdentificationNumber(?string $identificationNumber): self
    {
        $this->identificationNumber = $identificationNumber;

        return $this;
    }

    public function getRiskData(): ?CustomerRisk
    {
        return $this->riskData;
    }

    public function setRiskData(?CustomerRisk $riskData): self
    {
        $this->riskData = $riskData;

        return $this;
    }

    public function getSalutation(): ?string
    {
        return $this->salutation;
    }

    public function setSalutation(?string $salutation): self
    {
        $this->salutation = $salutation;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(?string $companyName): self
    {
        $this->companyName = $companyName;

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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }
}
