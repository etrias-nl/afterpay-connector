<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Type;

class Payment
{
    public const TYPE_INVOICE = 'Invoice';

    /** @var null|string */
    protected $type;

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
