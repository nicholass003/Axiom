<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type;

use Nicholass003\Axiom\Enum\AttributeLayerSettingsWeightType;
use pmmp\encoding\ByteBufferWriter;

abstract class AttributeLayerSettingsWeight{

    public function __construct(
        public readonly AttributeLayerSettingsWeightType $type
    ){}
}
