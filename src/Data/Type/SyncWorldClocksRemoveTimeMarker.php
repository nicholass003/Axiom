<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type;

use Nicholass003\Axiom\Enum\SyncWorldClocksType;

class SyncWorldClocksRemoveTimeMarker extends SyncWorldClocksPayload{

    public function __construct(
        public readonly int $clockId,
        public readonly array $markerIds
    ){
        parent::__construct(SyncWorldClocksType::REMOVE_TIME_MARKER);
    }
}
