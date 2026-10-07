<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type;

use Nicholass003\Axiom\Enum\AttributeValueType;

abstract class AttributeValue{

    public function __construct(
        public readonly AttributeValueType $type
    ){}
}
