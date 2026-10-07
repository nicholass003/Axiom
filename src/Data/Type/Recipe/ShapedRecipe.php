<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type\Recipe;

use Nicholass003\Axiom\Data\Type\ItemStack;
use Nicholass003\Axiom\Enum\RecipeType;

final class ShapedRecipe extends RecipeWithTypeId{

    /**
     * @param list<list<RecipeIngredient>> $input
     * @param list<ItemStack> $output
     */
    public function __construct(
        RecipeType $typeId,
        public readonly string $recipeId,
        public readonly array $input,
        public readonly array $output,
        public readonly string $uuid,
        public readonly string $blockName,
        public readonly int $priority,
        public readonly bool $symmetric,
        public readonly RecipeUnlockingRequirement $unlockingRequirement,
        public readonly int $recipeNetId
    ){
        parent::__construct($typeId);
    }
}
