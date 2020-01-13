<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Response;

class RefundOrderResponse
{
    /** @var string[] */
    protected $refundNumbers = [];

    /** @var null|float|int|string */
    protected $totalAuthorizedAmount;

    /** @var null|float|int|string */
    protected $totalCapturedAmount;

    /** @var null|float|int|string */
    protected $totalRefundedAmount;

    /**
     * @return string[]
     */
    public function getRefundNumbers(): array
    {
        return $this->refundNumbers;
    }

    /**
     * @param string[] $refundNumbers
     */
    public function setRefundNumbers(array $refundNumbers): self
    {
        $this->refundNumbers = $refundNumbers;

        return $this;
    }

    /**
     * @return null|float|int|string
     */
    public function getTotalAuthorizedAmount()
    {
        return $this->totalAuthorizedAmount;
    }

    /**
     * @param null|float|int|string $totalAuthorizedAmount
     *
     * @return RefundOrderResponse
     */
    public function setTotalAuthorizedAmount($totalAuthorizedAmount)
    {
        $this->totalAuthorizedAmount = $totalAuthorizedAmount;

        return $this;
    }

    /**
     * @return null|float|int|string
     */
    public function getTotalCapturedAmount()
    {
        return $this->totalCapturedAmount;
    }

    /**
     * @param null|float|int|string $totalCapturedAmount
     *
     * @return RefundOrderResponse
     */
    public function setTotalCapturedAmount($totalCapturedAmount)
    {
        $this->totalCapturedAmount = $totalCapturedAmount;

        return $this;
    }

    /**
     * @return null|float|int|string
     */
    public function getTotalRefundedAmount()
    {
        return $this->totalRefundedAmount;
    }

    /**
     * @param null|float|int|string $totalRefundedAmount
     *
     * @return RefundOrderResponse
     */
    public function setTotalRefundedAmount($totalRefundedAmount)
    {
        $this->totalRefundedAmount = $totalRefundedAmount;

        return $this;
    }
}
