<?php

namespace App\MessageHandler\Recipe\CreateRecipe;

use App\Enum\DifficultyEnum;

final readonly class CreateRecipeCommand
{
    /**
     * @param array<int> $tags
     */
    public function __construct(
        public string $name,
        public int $category,
        public DifficultyEnum $difficulty,
        public ?string $description = null,
        public ?array $tags = null,
    ) {
    }
}
