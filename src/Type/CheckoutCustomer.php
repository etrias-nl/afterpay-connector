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
    public $customerCategory;

    /** @var null|\DateTime */
    public $birthDate;

    /** @var null|string */
    public $email;

    /** @var null|string */
    public $identificationNumber;

    /** @var null|string */
    public $salutation;

    /** @var null|Address */
    public $address;

    /** @var null|string */
    public $companyName;

    /** @var null|string */
    public $customerNumber;

    /** @var null|string */
    public $firstName;

    /** @var null|string */
    public $lastName;

    /** @var null|string */
    public $phone;

    public static function forPerson(?string $email = null): self
    {
        $object = new self();
        $object->customerCategory = self::CATEGORY_PERSON;
        $object->email = $email;

        return $object;
    }

    public static function forCompany(?string $companyName = null): self
    {
        $object = new self();
        $object->customerCategory = self::CATEGORY_COMPANY;
        $object->companyName = $companyName;

        return $object;
    }

    public function withFullName(?string $salutation, ?string $firstName, ?string $lastName): self
    {
        $this->salutation = $salutation;
        $this->firstName = $firstName;
        $this->lastName = $lastName;

        return $this;
    }

    public function withBirthDate(int $day, int $month, int $year): self
    {
        $this->birthDate = (new \DateTime())->setTimestamp(mktime(0, 0, 0, $month, $day, $year));

        return $this;
    }
}
