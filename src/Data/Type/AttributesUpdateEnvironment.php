<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type;

use Nicholass003\Axiom\Enum\AttributeLayerSyncType;

class AttributesUpdateEnvironment extends AttributeLayerSyncPayload{

    public function __construct(
        public readonly string $name,
        public readonly int $dimension,
        public readonly array $attributes
    ){
        parent::__construct(AttributeLayerSyncType::UPDATE_ENVIRONMENT);
    }
}
