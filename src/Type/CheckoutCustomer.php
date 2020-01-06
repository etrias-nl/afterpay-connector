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

    /** @var null|\DateTimeInterface */
    public $birthDate;

    /** @var null|string */
    public $email;

    /** @var null|string */
    public $identificationNumber;

    /** @var null|CustomerRisk */
    public $riskData;

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

    public static function forPerson(): self
    {
        $customer = new self();
        $customer->customerCategory = self::CATEGORY_PERSON;

        return $customer;
    }

    public static function forCompany(): self
    {
        $customer = new self();
        $customer->customerCategory = self::CATEGORY_COMPANY;

        return $customer;
    }
}
