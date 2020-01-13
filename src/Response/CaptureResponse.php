<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Response;

class CaptureResponse
{
    /** @var null|float|int|string */
    protected $authorizedAmount;

    /** @var null|float|int|string */
    protected $capturedAmount;

    /** @var null|string */
    protected $captureNumber;

    /** @var null|float|int|string */
    protected $remainingAuthorizedAmount;

    /**
     * @return null|float|int|string
     */
    public function getAuthorizedAmount()
    {
        return $this->authorizedAmount;
    }

    /**
     * @param null|float|int|string $authorizedAmount
     *
     * @return CaptureResponse
     */
    public function setAuthorizedAmount($authorizedAmount)
    {
        $this->authorizedAmount = $authorizedAmount;

        return $this;
    }

    /**
     * @return null|float|int|string
     */
    public function getCapturedAmount()
    {
        return $this->capturedAmount;
    }

    /**
     * @param null|float|int|string $capturedAmount
     *
     * @return CaptureResponse
     */
    public function setCapturedAmount($capturedAmount)
    {
        $this->capturedAmount = $capturedAmount;

        return $this;
    }

    public function getCaptureNumber(): ?string
    {
        return $this->captureNumber;
    }

    public function setCaptureNumber(?string $captureNumber): self
    {
        $this->captureNumber = $captureNumber;

        return $this;
    }

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
     * @return CaptureResponse
     */
    public function setRemainingAuthorizedAmount($remainingAuthorizedAmount)
    {
        $this->remainingAuthorizedAmount = $remainingAuthorizedAmount;

        return $this;
    }
}
