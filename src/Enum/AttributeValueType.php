<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Enum;

/**
 * Attribute value discriminator.
 *
 * The enum values are kept unchanged for backward compatibility. They are NOT the wire IDs:
 * the protocol encodes BOOL = 0, FLOAT = 1 and COLOR = 2. Use {@see toWireId()} /
 * {@see fromWireId()} when reading from or writing to the network stream.
 */
enum AttributeValueType : int{

    case FLOAT = 0;
    case COLOR = 1;
    case BOOL = 2;

    /**
     * Returns the protocol (wire) ID for this value type.
     */
    public function toWireId() : int{
        return match($this){
            self::BOOL => 0,
            self::FLOAT => 1,
            self::COLOR => 2,
        };
    }

    /**
     * Resolves an enum case from its protocol (wire) ID. Returns null for unknown IDs.
     */
    public static function fromWireId(int $id) : ?self{
        return match($id){
            0 => self::BOOL,
            1 => self::FLOAT,
            2 => self::COLOR,
            default => null,
        };
    }
}
