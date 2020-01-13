<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Type;

class PaymentMethod
{
    /** @var null|string */
    protected $logo;

    /** @var null|string */
    protected $tag;

    /** @var null|string */
    protected $title;

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getTag(): ?string
    {
        return $this->tag;
    }

    public function setTag(?string $tag): self
    {
        $this->tag = $tag;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }
}
