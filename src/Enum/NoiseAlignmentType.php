<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Enum;

enum NoiseAlignmentType : int{
    use OrdinalEnumTrait;

    case MIN_LOCAL_TRANSITION_END = 0;
}
