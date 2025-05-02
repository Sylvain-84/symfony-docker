<?php

namespace App\MessageHandler\Recipe\UpdateRecipe;

use App\Enum\DifficultyEnum;

final readonly class UpdateRecipeCommand
{
    /**
     * @param array<int> $tags
     * @param array<int> $utensils
     */
    public function __construct(
        public int $id,
        public int $category,
        public string $name,
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
