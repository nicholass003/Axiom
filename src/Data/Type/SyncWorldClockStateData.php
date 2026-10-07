<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type;

class SyncWorldClockStateData{

    public function __construct(
        public readonly int $clockId,
        public readonly int $time,
        public readonly bool $paused
    ){}
}
