<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Enum;

enum InputMode : int{

    case MOUSE_KEYBOARD = 1;
    case TOUCHSCREEN = 2;
    case GAME_PAD = 3;

    /** @deprecated v859 */
    case MOTION_CONTROLLER = 4;

    public static function safe(int $value) : self{
        return self::tryFrom($value) ?? self::MOUSE_KEYBOARD;
    }
}
