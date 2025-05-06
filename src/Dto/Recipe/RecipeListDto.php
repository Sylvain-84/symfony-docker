<?php

declare(strict_types=1);

namespace App\Dto\Recipe;

final readonly class RecipeListDto
{
    private function __construct(
        public int $id,
        public string $category,
        public string $name,
        public string $difficulty,
    ) {
    }

    public static function transform(string $category, string $name, int $id, string $difficulty): self
    {
        return new self(
            id: $id,
            category: $category,
            name: $name,
            difficulty: $difficulty
        );
    }
}
