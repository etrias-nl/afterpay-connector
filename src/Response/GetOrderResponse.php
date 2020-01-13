<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Response;

use Etrias\AfterPayConnector\Type\Cancellation;
use Etrias\AfterPayConnector\Type\Capture;
use Etrias\AfterPayConnector\Type\Payment;
use Etrias\AfterPayConnector\Type\Refund;
use Etrias\AfterPayConnector\Type\ResponseOrderDetails;

class GetOrderResponse
{
    /** @var Cancellation[] */
    protected $cancellations = [];

    /** @var Capture[] */
    protected $captures = [];

    /** @var null|ResponseOrderDetails */
    protected $orderDetails;

    /** @var null|Payment */
    protected $payment;

    /** @var Refund[] */
    protected $refunds = [];

    /**
     * @return Cancellation[]
     */
    public function getCancellations(): array
    {
        return $this->cancellations;
    }

    /**
     * @param Cancellation[] $cancellations
     */
    public function setCancellations(array $cancellations): self
    {
        $this->cancellations = $cancellations;

        return $this;
    }

    /**
     * @return Capture[]
     */
    public function getCaptures(): array
    {
        return $this->captures;
    }

    /**
     * @param Capture[] $captures
     */
    public function setCaptures(array $captures): self
    {
        $this->captures = $captures;

        return $this;
    }

    public function getOrderDetails(): ?ResponseOrderDetails
    {
        return $this->orderDetails;
    }

    public function setOrderDetails(?ResponseOrderDetails $orderDetails): self
    {
        $this->orderDetails = $orderDetails;

        return $this;
    }

    public function getPayment(): ?Payment
    {
        return $this->payment;
    }

    public function setPayment(?Payment $payment): self
    {
        $this->payment = $payment;

        return $this;
    }

    /**
     * @return Refund[]
     */
    public function getRefunds(): array
    {
        return $this->refunds;
    }

    /**
     * @param Refund[] $refunds
     */
    public function setRefunds(array $refunds): self
    {
        $this->refunds = $refunds;

        return $this;
    }
}
