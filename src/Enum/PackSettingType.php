<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Enum;

enum PackSettingType : int{

    case UNKNOWN = -1;
    case FLOAT = 0;
    case BOOL = 1;
    case STRING = 2;
    /** @since v2193 */
    case STRING_ARRAY = 3;

    public static function safe(int $value) : self{
        return self::tryFrom($value) ?? self::UNKNOWN;
    }
}
