<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Enum;

enum ScriptDebugShapeType : int{

    case UNKNOWN = -1;
    case LINE = 0;
    case BOX = 1;
    case SPHERE = 2;
    case CIRCLE = 3;
    case TEXT = 4;
    case ARROW = 5;

    public const PAYLOAD_TYPE_NONE = 0;
    public const PAYLOAD_TYPE_ARROW = 1;
    public const PAYLOAD_TYPE_TEXT = 2;
    public const PAYLOAD_TYPE_BOX = 3;
    public const PAYLOAD_TYPE_LINE = 4;
    public const PAYLOAD_TYPE_CIRCLE_OR_SPHERE = 5;

    public function getPayloadType() : int{
        return match($this){
            self::ARROW => self::PAYLOAD_TYPE_ARROW,
            self::TEXT => self::PAYLOAD_TYPE_TEXT,
            self::BOX => self::PAYLOAD_TYPE_BOX,
            self::LINE => self::PAYLOAD_TYPE_LINE,
            self::CIRCLE, self::SPHERE => self::PAYLOAD_TYPE_CIRCLE_OR_SPHERE
        };
    }

    public static function safe(int $value) : self{
        return self::tryFrom($value) ?? self::UNKNOWN;
    }
}
