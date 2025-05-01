<?php

namespace App\MessageHandler\Recipe\CreateRecipe;

final readonly class CreateRecipeCommand
{
    /**
     * @param array<int> $tags
     */
    public function __construct(
        public string $name,
        public int $category,
        public ?string $description = null,
        public ?array $tags = null,
    ) {
    }
}
