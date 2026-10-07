<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type;

use Nicholass003\Axiom\Enum\AttributeValueColorType;
use Nicholass003\Axiom\Enum\AttributeValueType;

class AttributeValueColor extends AttributeValue{

    public const OPERATION_OVERRIDE = "override";
    public const OPERATION_ALPHA_BLEND = "alpha_blend";
    public const OPERATION_ADD = "add";
    public const OPERATION_SUBTRACT = "subtract";
    public const OPERATION_MULTIPLY = "multiply";

    public function __construct(
        public readonly AttributeValueColorValue $value,
        public readonly string $operation
    ){
        parent::__construct(AttributeValueType::COLOR);
    }
}
