<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type\Furnace;

use Nicholass003\Axiom\Enum\PacketIntEnumTrait;

enum FurnaceLayout : int{
    use PacketIntEnumTrait;

    case NONE = 0;
    case INVENTORY_ONLY = 1;
    case DEFAULT = 2;
}
