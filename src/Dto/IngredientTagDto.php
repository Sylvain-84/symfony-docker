<?php

namespace App\Dto;

final readonly class IngredientTagDto
{
    private function __construct(
        public int $id,
        public string $name,
    ) {
    }

    public static function transform(string $name, int $id): self
    {
        return new self(
            id: $id,
            name: $name
        );
    }
}
