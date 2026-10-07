<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type;

class AttributeLayer{

    public function __construct(
        public readonly string $name,
        public readonly int $dimension,
        public readonly AttributeLayerSettings $settings,
        public readonly array $attributes
    ){}
}
