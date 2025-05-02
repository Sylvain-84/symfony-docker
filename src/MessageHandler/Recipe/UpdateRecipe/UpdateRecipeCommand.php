<?php

namespace App\MessageHandler\Recipe\UpdateRecipe;

use App\Enum\DifficultyEnum;

final readonly class UpdateRecipeCommand
{
    /**
     * @param array<int> $tags
     */
    public function __construct(
        public int $id,
        public int $category,
        public string $name,
        public DifficultyEnum $difficulty,
        public int $servings,
        public ?string $description = null,
        public ?array $tags = null,
    ) {
    }
}
