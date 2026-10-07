<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type;

use Nicholass003\Axiom\Enum\AttributeValueColorType;
use pmmp\encoding\ByteBufferWriter;

abstract class AttributeValueColorValue{

    public function __construct(
        public readonly AttributeValueColorType $type
    ){}
}
