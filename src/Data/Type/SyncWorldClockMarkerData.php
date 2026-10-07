<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type;

class SyncWorldClockMarkerData{

    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly int $time,
        public readonly ?int $period
    ){}
}
