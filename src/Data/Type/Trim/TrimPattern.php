<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type\Trim;

class TrimPattern{

    public function __construct(
        public readonly string $itemId,
        public readonly string $patternId
    ){}
}
