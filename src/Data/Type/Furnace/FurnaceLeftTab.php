<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type\Furnace;

use Nicholass003\Axiom\Enum\PacketIntEnumTrait;

/**
 * Spec name: FurnaceLeftTabIndex
 */
enum FurnaceLeftTab : int{
    use PacketIntEnumTrait;

    case NONE = 0;
    case RECIPE_FOOD = 1;
    case RECIPE_ITEMS = 2;
    case RECIPE_BLOCKS = 3;
    case RECIPE_SEARCH = 4;
    case INVENTORY = 5;
}
