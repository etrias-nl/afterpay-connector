<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Response;

use Etrias\AfterPayConnector\Type\Capture;

class GetAllCapturesResponse
{
    /** @var Capture[] */
    protected $captures = [];

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
}
