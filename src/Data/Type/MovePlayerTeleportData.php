<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type;

final class MovePlayerTeleportData{

    public function __construct(
        public readonly int $cause,
        public readonly int $sourceActorType
    ){}
}
