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
        public int $preparationTime,
        public int $cookingTime,
        public ?int $note,
    ) {
    }

    public static function transform(
        string $category,
        string $name,
        int $id,
        string $difficulty,
        int $preparationTime,
        int $cookingTime,
        ?int $note,
    ): self {
        return new self(
            id: $id,
            category: $category,
            name: $name,
            difficulty: $difficulty,
            preparationTime: $preparationTime,
            cookingTime: $cookingTime,
            note: $note,
        );
    }
}
