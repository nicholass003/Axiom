<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type;

use Nicholass003\Axiom\Enum\AttributeValueColorType;
use pocketmine\color\Color;

class AttributeValueColorArray extends AttributeValueColorValue{

    public function __construct(
        public readonly Color $value
    ){
        parent::__construct(AttributeValueColorType::RGB);
    }
}
