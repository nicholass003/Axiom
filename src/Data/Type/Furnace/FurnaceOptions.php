<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type\Furnace;

final class FurnaceOptions{

    public function __construct(
        public readonly FurnaceLeftTab $leftFurnaceTab,
        public readonly bool $filtering,
        public readonly FurnaceLayout $layout
    ){}
}
