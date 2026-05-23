<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type;

/** @since v975 */
class PresenceConfig{

    public function __construct(
        public readonly string $experienceName,
        public readonly string $worldName
    ){}
}
