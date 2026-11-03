<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Enum;

enum InventoryLayout : int{

    case NONE = 0;
    case INVENTORY_ONLY = 1;
    case DEFAULT = 2;
    case RECIPE_BOOK_ONLY = 3;

    public static function safe(int $value) : self{
        return self::tryFrom($value) ?? self::NONE;
    }
}
