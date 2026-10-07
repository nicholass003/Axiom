<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type\Furnace;

use Nicholass003\Axiom\Enum\PacketIntEnumTrait;

enum FurnaceType : int{
    use PacketIntEnumTrait;

    case NONE = 0;
    case FURNACE = 1;
    case BLAST_FURNACE = 2;
    case SMOKER = 3;
}
