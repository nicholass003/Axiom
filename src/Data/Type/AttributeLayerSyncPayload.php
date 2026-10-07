<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type;

use Nicholass003\Axiom\Enum\AttributeLayerSyncType;

abstract class AttributeLayerSyncPayload{

    public function __construct(
        public readonly AttributeLayerSyncType $type
    ){}
}
