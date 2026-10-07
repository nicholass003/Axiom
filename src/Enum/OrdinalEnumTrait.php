<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Enum;

use InvalidArgumentException;

/**
 * Trait for enums serialized in packets with ordinal-based case resolution.
 * Provides helpers to read ordinal, validate and write ordinal.
 */
trait OrdinalEnumTrait{

    /**
     * @throws InvalidArgumentException
     */
    public static function fromOrdinal(int $ordinal) : self{
        $cases = self::cases();
        if(!isset($cases[$ordinal])){
            throw new InvalidArgumentException("Invalid ordinal value $ordinal for " . static::class);
        }
        return $cases[$ordinal];
    }

    /**
     * Alias for fromOrdinal, used in packet decoding.
     *
     * @throws InvalidArgumentException
     */
    public static function fromPacket(int $value) : self{
        return self::fromOrdinal($value);
    }

    public function toOrdinal() : int{
        /** @var array<string, int> $ordinals */
        static $ordinals = [];

        $class = static::class;
        if(!isset($ordinals[$class])){
            $ordinals[$class] = [];
            foreach(self::cases() as $i => $case){
                $ordinals[$class][$case->name] = $i;
            }
        }

        return $ordinals[$class][$this->name] ?? throw new InvalidArgumentException("Unknown case: " . $this->name);
    }

    /**
     * Alias for toOrdinal, used in packet encoding.
     */
    public function toPacket() : int{
        return $this->toOrdinal();
    }
}
