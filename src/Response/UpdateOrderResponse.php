<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Response;

class UpdateOrderResponse
{
    /** @var null|string */
    protected $checkoutId;

    /** @var null|\DateTime */
    protected $expirationDate;

    /** @var null|string */
    protected $outcome;

    /** @var null|string */
    protected $reservationId;

    public function getCheckoutId(): ?string
    {
        return $this->checkoutId;
    }

    public function setCheckoutId(?string $checkoutId): self
    {
        $this->checkoutId = $checkoutId;

        return $this;
    }

    public function getExpirationDate(): ?\DateTime
    {
        return $this->expirationDate;
    }

    public function setExpirationDate(?\DateTime $expirationDate): self
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }

    public function getOutcome(): ?string
    {
        return $this->outcome;
    }

    public function setOutcome(?string $outcome): self
    {
        $this->outcome = $outcome;

        return $this;
    }

    public function getReservationId(): ?string
    {
        return $this->reservationId;
    }

    public function setReservationId(?string $reservationId): self
    {
        $this->reservationId = $reservationId;

        return $this;
    }
}
