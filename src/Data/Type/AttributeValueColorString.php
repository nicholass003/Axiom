<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type;

use Nicholass003\Axiom\Enum\AttributeValueColorType;

class AttributeValueColorString extends AttributeValueColorValue{

    public function __construct(
        public readonly string $value
    ){
        parent::__construct(AttributeValueColorType::HEX);
    }
}
