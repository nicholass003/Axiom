<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type;

use Nicholass003\Axiom\Enum\NoiseAlignmentType;

final class NoiseAlignment{

    public function __construct(
        public readonly NoiseAlignmentType $type,
        public readonly int $value
    ){}
}
