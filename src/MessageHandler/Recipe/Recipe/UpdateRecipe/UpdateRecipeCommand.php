<?php

declare(strict_types=1);

namespace App\MessageHandler\Recipe\Recipe\UpdateRecipe;

use App\Enum\DifficultyEnum;
use App\MessageHandler\Recipe\Recipe\InstructionInput;
use App\MessageHandler\Recipe\Recipe\RecipeIngredientInput;

final readonly class UpdateRecipeCommand
{
    /**
     * @param list<int>                   $tags
     * @param list<int>                   $utensils
     * @param list<InstructionInput>      $instructions
     * @param list<RecipeIngredientInput> $ingredients
     */
    public function __construct(
        public int $id,
        public int $categoryId,
        public string $name,
        public DifficultyEnum $difficulty,
        public int $servings = 1,
        public int $preparationTime = 0,
        public int $cookingTime = 0,
        public ?string $description = null,
        public ?array $tags = null,
        public ?array $utensils = null,
        public ?int $note = null,
        public ?array $instructions = null,
        public array $ingredients = [],
    ) {
    }
}
