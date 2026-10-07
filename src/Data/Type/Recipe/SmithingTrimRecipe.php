<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type\Recipe;

use Nicholass003\Axiom\Enum\RecipeType;

final class SmithingTrimRecipe extends RecipeWithTypeId{

    public function __construct(
        RecipeType $typeId,
        public readonly string $recipeId,
        public readonly RecipeIngredient $template,
        public readonly RecipeIngredient $input,
        public readonly RecipeIngredient $addition,
        public readonly string $blockName,
        public readonly int $recipeNetId
    ){
        parent::__construct($typeId);
    }
}
