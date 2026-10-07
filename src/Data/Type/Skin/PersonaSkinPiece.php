<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type\Skin;

use Nicholass003\Axiom\Enum\PersonaSkinPieceType;

class PersonaSkinPiece{

    public function __construct(
        public readonly string $pieceId,
        public readonly PersonaSkinPieceType $pieceType,
        public readonly string $packId,
        public readonly bool $isDefaultPiece,
        public readonly string $productId
    ){}
}
