<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type;

use Nicholass003\Axiom\Enum\SyncWorldClocksType;

abstract class SyncWorldClocksPayload{

    public function __construct(
        public readonly SyncWorldClocksType $type
    ){}
}
