<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Request;

use Etrias\AfterPayConnector\Type\Payment;

class AuthorizePaymentRequest
{
    use AuthorizeRequestTrait;

    /** @var null|Payment */
    protected $payment;

    /** @var null|string */
    protected $checkoutId;

    /** @var null|string */
    protected $merchantId;

    public function getPayment(): ?Payment
    {
        return $this->payment;
    }

    public function setPayment(?Payment $payment): self
    {
        $this->payment = $payment;

        return $this;
    }

    public function getCheckoutId(): ?string
    {
        return $this->checkoutId;
    }

    public function setCheckoutId(?string $checkoutId): self
    {
        $this->checkoutId = $checkoutId;

        return $this;
    }

    public function getMerchantId(): ?string
    {
        return $this->merchantId;
    }

    public function setMerchantId(?string $merchantId): self
    {
        $this->merchantId = $merchantId;

        return $this;
    }
}
