<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type;

class SyncWorldClockData{

    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly int $time,
        public readonly bool $paused,
        public readonly array $markers
    ){}
}
