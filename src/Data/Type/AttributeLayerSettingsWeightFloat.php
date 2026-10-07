<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type;

use Nicholass003\Axiom\Enum\AttributeLayerSettingsWeightType;

class AttributeLayerSettingsWeightFloat extends AttributeLayerSettingsWeight{

    public function __construct(
        public readonly float $value
    ){
        parent::__construct(AttributeLayerSettingsWeightType::FLOAT);
    }
}
