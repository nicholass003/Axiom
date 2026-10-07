<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type;

use Nicholass003\Axiom\Enum\AttributeLayerSyncType;

class AttributeUpdateLayers extends AttributeLayerSyncPayload{

    public function __construct(
        public readonly array $layers
    ){
        parent::__construct(AttributeLayerSyncType::UPDATE_LAYERS);
    }
}
