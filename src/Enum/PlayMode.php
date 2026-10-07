<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Enum;

enum PlayMode : int{

    case NORMAL = 0;
    case TEASER = 1;
    case SCREEN = 2;

    /** @deprecated v859 */
    case VIEWER = 3;

    /** @deprecated v859 */
    case VR = 4;

    /** @deprecated v859 */
    case PLACEMENT = 5;

    /** @deprecated v859 */
    case LIVING_ROOM = 6;

    case EXIT_LEVEL = 7;

    /** @deprecated v859 */
    case EXIT_LEVEL_LIVING_ROOM = 8;

    public static function safe(int $value) : self{
        return self::tryFrom($value) ?? self::NORMAL;
    }
}
