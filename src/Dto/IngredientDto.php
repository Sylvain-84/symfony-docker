<?php

declare(strict_types=1);

// src/Dto/IngredientDto.php

namespace App\Dto;

final readonly class IngredientDto
{
    private function __construct(
        public int $id,
        public int $categoryId,
        public string $name,
    ) {
    }

    public static function transform(int $categoryId, string $name, int $id): self
    {
        return new self(
            id: $id,
            categoryId: $categoryId,
            name: $name
        );
    }
}
