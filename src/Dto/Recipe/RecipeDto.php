<?php

declare(strict_types=1);

// src/Dto/IngredientDto.php

namespace App\Dto\Recipe;

final readonly class RecipeDto
{
    private function __construct(
        public int $id,
        public int $categoryId,
        public string $name,
        public string $difficulty,
    ) {
    }

    public static function transform(int $categoryId, string $name, int $id, string $difficulty): self
    {
        return new self(
            id: $id,
            categoryId: $categoryId,
            name: $name,
            difficulty: $difficulty
        );
    }
}
