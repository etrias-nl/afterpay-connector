<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Response;

use Etrias\AfterPayConnector\Type\Cancellation;

class GetVoidsResponse
{
    /** @var Cancellation[] */
    protected $cancellations = [];

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
}
