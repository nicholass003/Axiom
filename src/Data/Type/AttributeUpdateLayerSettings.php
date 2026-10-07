<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type;

use Nicholass003\Axiom\Enum\AttributeLayerSyncType;

class AttributeUpdateLayerSettings extends AttributeLayerSyncPayload{

    public function __construct(
        public readonly string $name,
        public readonly int $dimension,
        public readonly AttributeLayerSettings $settings
    ){
        parent::__construct(AttributeLayerSyncType::UPDATE_LAYER_SETTINGS);
    }
}
