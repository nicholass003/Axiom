<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type;

use Nicholass003\Axiom\Enum\AttributeValueType;

class AttributeValueBool extends AttributeValue{

    public const OPERATION_OVERRIDE = "override";
    public const OPERATION_ALPHA_BLEND = "alpha_blend";
    public const OPERATION_AND = "and";
    public const OPERATION_NAND = "nand";
    public const OPERATION_OR = "or";
    public const OPERATION_NOR = "nor";
    public const OPERATION_XOR = "xor";
    public const OPERATION_XNOR = "xnor";

    public function __construct(
        public readonly bool $value,
        public readonly string $operation
    ){
        parent::__construct(AttributeValueType::BOOL);
    }
}
