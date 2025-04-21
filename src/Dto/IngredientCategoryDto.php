<?php

namespace App\Dto;

final readonly class IngredientCategoryDto
{
    private function __construct(
        public int $id,
        public string $name,
    ) {
    }

    public static function transform(string $name, int $id)
    {
        return new self(
            id: $id,
            name: $name
        );
    }
}
