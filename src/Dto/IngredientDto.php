<?php
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

    public static function transform(int $categoryId, string $name, int $id)
    {
        return new self(
            id: $id,
            categoryId: $categoryId,
            name: $name
        );
    }
}
