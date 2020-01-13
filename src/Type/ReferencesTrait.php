<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Type;

trait ReferencesTrait
{
    /** @var null|string */
    protected $ourReference;

    /** @var null|string */
    protected $yourReference;

    public function getOurReference(): ?string
    {
        return $this->ourReference;
    }

    public function setOurReference(?string $ourReference): self
    {
        $this->ourReference = $ourReference;

        return $this;
    }

    public function getYourReference(): ?string
    {
        return $this->yourReference;
    }

    public function setYourReference(?string $yourReference): self
    {
        $this->yourReference = $yourReference;

        return $this;
    }
}
