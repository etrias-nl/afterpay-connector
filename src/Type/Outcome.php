<?php

declare(strict_types=1);

namespace Etrias\AfterPayConnector\Type;

abstract class Outcome
{
    public const ACCEPTED = 'Accepted';
    public const PENDING = 'Pending';
    public const REJECTED = 'Rejected';
    public const NOT_EVALUATED = 'NotEvaluated';
}
