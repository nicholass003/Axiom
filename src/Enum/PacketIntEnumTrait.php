<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Enum;

/**
 * Trait for packet-based integer enums.
 * Provides fromPacket/toPacket helpers.
 */
trait PacketIntEnumTrait{

    public static function fromPacket(int $value) : self{
        return self::fromOrdinal($value);
    }

    public function toPacket() : int{
        return $this->toOrdinal();
    }
}
