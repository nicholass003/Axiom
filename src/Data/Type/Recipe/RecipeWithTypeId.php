<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type\Recipe;

use Nicholass003\Axiom\Enum\RecipeType;

abstract class RecipeWithTypeId{

    public function __construct(
        public readonly RecipeType $typeId
    ){}
}
