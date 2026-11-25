<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Enum;

/**
 * Colour attribute payload discriminator.
 *
 * The enum values are kept unchanged for backward compatibility. They are NOT the wire IDs:
 * the protocol encodes STRING (hex string) = 0 and ARRAY (channel list) = 1. Use
 * {@see toWireId()} / {@see fromWireId()} when reading from or writing to the network stream.
 */
enum AttributeValueColorType : int{

    /** Array of RGBA channels. */
    case RGB = 0;
    /** Hex colour string. */
    case HEX = 1;

    /**
     * Returns the protocol (wire) ID for this colour type.
     */
    public function toWireId() : int{
        return match($this){
            self::HEX => 0,
            self::RGB => 1,
        };
    }

    /**
     * Resolves an enum case from its protocol (wire) ID. Returns null for unknown IDs.
     */
    public static function fromWireId(int $id) : ?self{
        return match($id){
            0 => self::HEX,
            1 => self::RGB,
            default => null,
        };
    }
}
