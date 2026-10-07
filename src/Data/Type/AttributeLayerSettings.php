<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type;

class AttributeLayerSettings{

    public function __construct(
        public readonly int $priority,
        public readonly AttributeLayerSettingsWeight $weight,
        public readonly bool $enabled,
        public readonly bool $transitionsPaused
    ){}
}
