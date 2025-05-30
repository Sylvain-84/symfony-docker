<?php

declare(strict_types=1);

namespace App\MessageHandler\Recipe\Recipe;

use App\Enum\UnityEnum;

final readonly class RecipeIngredientInput
{
    public function __construct(
        public int $id,
        public float $quantity,
        public UnityEnum $unity,
    ) {
    }
}
