<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type\Recipe;

use Nicholass003\Axiom\Data\Type\ItemStack;
use Nicholass003\Axiom\Enum\RecipeType;

final class ShapelessRecipe extends RecipeWithTypeId{

    /**
     * @param list<RecipeIngredient> $inputs
     * @param list<ItemStack> $outputs
     */
    public function __construct(
        RecipeType $typeId,
        public readonly string $recipeId,
        public readonly array $inputs,
        public readonly array $outputs,
        public readonly string $uuid,
        public readonly string $blockName,
        public readonly int $priority,
        public readonly RecipeUnlockingRequirement $unlockingRequirement,
        public readonly int $recipeNetId
    ){
        parent::__construct($typeId);
    }
}
