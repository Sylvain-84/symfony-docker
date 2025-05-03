<?php

declare(strict_types=1);

namespace App\Dto\Ingredient;

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
