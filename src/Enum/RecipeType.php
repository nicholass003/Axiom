<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Enum;

enum RecipeType : int{

    case UNKNOWN = -1;
    case SHAPELESS = 0;
    case SHAPED = 1;
    case FURNACE = 2;
    case FURNACE_DATA = 3;
    case MULTI = 4;
    case USER_DATA_SHAPELESS = 5;
    case SHAPELESS_CHEMISTRY = 6;
    case SHAPED_CHEMISTRY = 7;
    case SMITHING_TRANSFORM = 8;
    case SMITHING_TRIM = 9;

    public static function safe(int $value) : self{
        return self::tryFrom($value) ?? self::UNKNOWN;
    }
}
