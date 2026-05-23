<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type\Recipe;

abstract class RecipeWithTypeId{

    public function __construct(
        public readonly int $typeId
    ){}
}
