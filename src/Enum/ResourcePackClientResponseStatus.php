<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Enum;

enum ResourcePackClientResponseStatus : string{
    use OrdinalEnumTrait;

	case STATUS_REFUSED = "cancel";
	case STATUS_SEND_PACKS = "downloading";
	case STATUS_HAVE_ALL_PACKS = "downloadingfinished";
	case STATUS_COMPLETED = "resourcepackstackfinished";

    public static function fromLegacyIndex(int $index) : self{
        return match($index){
            1 => self::STATUS_REFUSED,
            2 => self::STATUS_SEND_PACKS,
            3 => self::STATUS_HAVE_ALL_PACKS,
            4 => self::STATUS_COMPLETED,
            default => throw new \UnexpectedValueException("Unknown legacy resource pack client response status index $index"),
        };
    }

    public function toLegacyIndex() : int{
        return match($this){
            self::STATUS_REFUSED => 1,
            self::STATUS_SEND_PACKS => 2,
            self::STATUS_HAVE_ALL_PACKS => 3,
            self::STATUS_COMPLETED => 4,
        };
    }
}
