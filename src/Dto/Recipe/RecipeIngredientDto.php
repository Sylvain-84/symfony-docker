<?php

declare(strict_types=1);

// src/Dto/IngredientDto.php

namespace App\Dto\Recipe;

use App\Enum\UnityEnum;

final readonly class RecipeIngredientDto
{
    private function __construct(
        public int $id,
        public string $name,
        public float $quantity,
        public string $unity,
    ) {
    }

    public static function transform(
        int $id,
        string $name,
        float $quantity,
        UnityEnum $unity,
    ): self {
        return new self(
            id: $id,
            name: $name,
            quantity: $quantity,
            unity: $unity->value,
        );
    }
}
