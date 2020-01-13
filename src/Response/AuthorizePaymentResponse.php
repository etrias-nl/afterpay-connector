<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Response;

class AuthorizePaymentResponse
{
    use AuthorizeResponseTrait;

    /** @var null|string */
    protected $reservationId;

    /** @var null|\DateTime */
    protected $expirationDate;

    public function getReservationId(): ?string
    {
        return $this->reservationId;
    }

    public function setReservationId(?string $reservationId): self
    {
        $this->reservationId = $reservationId;

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
}
