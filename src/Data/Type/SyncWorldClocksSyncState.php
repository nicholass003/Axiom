<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type;

use Nicholass003\Axiom\Enum\SyncWorldClocksType;

class SyncWorldClocksSyncState extends SyncWorldClocksPayload{

    public function __construct(
        public readonly array $states
    ){
        parent::__construct(SyncWorldClocksType::SYNC_STATE);
    }
}
