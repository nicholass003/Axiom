<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type\Skin;

use Nicholass003\Axiom\Codec\Common\Color;
use Nicholass003\Axiom\Enum\PersonaSkinPieceType;

class PersonaPieceTintColor{

    /**
     * @param Color[] $colors
     * @phpstan-param array{Color, Color, Color, Color} $colors
     */
    public function __construct(
        public readonly PersonaSkinPieceType $pieceType,
        public readonly array $colors
    ){
        if(count($this->colors) !== 4){
            throw new \InvalidArgumentException("Colors array must contain exactly 4 Color objects");
        }
    }
}
