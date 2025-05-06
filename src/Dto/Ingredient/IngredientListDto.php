<?php

declare(strict_types=1);

// src/Dto/IngredientDto.php

namespace App\Dto\Ingredient;

final readonly class IngredientListDto
{
    private function __construct(
        public int $id,
        public string $category,
        public string $name,
    ) {
    }

    public static function transform(string $category, string $name, int $id): self
    {
        return new self(
            id: $id,
            category: $category,
            name: $name
        );
    }
}
