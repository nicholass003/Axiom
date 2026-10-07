<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type\Sound;

use Nicholass003\Axiom\Enum\SoundDataEventType;

/**
 * @since v2168
 */
final class SoundDataEvent{

    public function __construct(
        public readonly SoundDataEventType $type,
        public readonly ?float $volume = null,
        public readonly ?float $pitch = null,
        public readonly ?float $duration = null,
        public readonly ?float $targetVolume = null,
        public readonly ?float $seconds = null,
    ){}
}
