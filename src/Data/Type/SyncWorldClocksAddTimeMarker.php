<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type;

use Nicholass003\Axiom\Enum\SyncWorldClocksType;

class SyncWorldClocksAddTimeMarker extends SyncWorldClocksPayload{

    public function __construct(
        public readonly int $clockId,
        public readonly array $markers
    ){
        parent::__construct(SyncWorldClocksType::ADD_TIME_MARKER);
    }
}
