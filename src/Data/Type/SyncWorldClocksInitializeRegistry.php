<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type;

use Nicholass003\Axiom\Enum\SyncWorldClocksType;

class SyncWorldClocksInitializeRegistry extends SyncWorldClocksPayload{

    public function __construct(
        public readonly array $clocks
    ){
        parent::__construct(SyncWorldClocksType::INITIALIZE_REGISTRY);
    }
}
