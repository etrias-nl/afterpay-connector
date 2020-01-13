<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Response;

use Etrias\AfterPayConnector\Type\PaymentMethod;

class AvailablePaymentMethodsResponse
{
    use AuthorizeResponseTrait;

    /** @var PaymentMethod[] */
    protected $paymentMethods = [];

    /**
     * @return PaymentMethod[]
     */
    public function getPaymentMethods(): array
    {
        return $this->paymentMethods;
    }

    /**
     * @param PaymentMethod[] $paymentMethods
     */
    public function setPaymentMethods(array $paymentMethods): self
    {
        $this->paymentMethods = $paymentMethods;

        return $this;
    }
}
