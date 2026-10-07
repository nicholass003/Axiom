<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Enum;

enum HandSlot : int{
    use OrdinalEnumTrait;

    case MAINHAND = 0;
    case OFFHAND = 1;
}
