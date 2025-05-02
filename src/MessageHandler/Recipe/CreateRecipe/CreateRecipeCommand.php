<?php

namespace App\MessageHandler\Recipe\CreateRecipe;

use App\Enum\DifficultyEnum;

final readonly class CreateRecipeCommand
{
    /**
     * @param array<int> $tags
     * @param array<int> $utensils
     */
    public function __construct(
        public string $name,
        public int $category,
        public DifficultyEnum $difficulty,
        public int $servings,
        public int $preparationTime = 0,
        public int $cookingTime = 0,
        public ?string $description = null,
        public ?array $tags = null,
        public ?array $utensils = null,
    ) {
    }
}
