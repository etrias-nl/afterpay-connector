<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Response;

class VoidAuthorizationResponse
{
    /** @var null|float|int|string */
    protected $remainingAuthorizedAmount;

    /** @var null|float|int|string */
    protected $totalAuthorizedAmount;

    /** @var null|float|int|string */
    protected $totalCapturedAmount;

    /**
     * @return null|float|int|string
     */
    public function getRemainingAuthorizedAmount()
    {
        return $this->remainingAuthorizedAmount;
    }

    /**
     * @param null|float|int|string $remainingAuthorizedAmount
     *
     * @return VoidAuthorizationResponse
     */
    public function setRemainingAuthorizedAmount($remainingAuthorizedAmount)
    {
        $this->remainingAuthorizedAmount = $remainingAuthorizedAmount;

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
     * @return VoidAuthorizationResponse
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
     * @return VoidAuthorizationResponse
     */
    public function setTotalCapturedAmount($totalCapturedAmount)
    {
        $this->totalCapturedAmount = $totalCapturedAmount;

        return $this;
    }
}
