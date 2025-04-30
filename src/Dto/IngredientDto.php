<?php

// src/Dto/IngredientDto.php

namespace App\Dto;

final readonly class IngredientDto
{
    private function __construct(
        public int $id,
        public string $category,
        public string $name,
    ) {
    }

    public static function transform(string $category, string $name, int $id)
    {
        return new self(
            id: $id,
            category: $category,
            name: $name
        );
    }
}
