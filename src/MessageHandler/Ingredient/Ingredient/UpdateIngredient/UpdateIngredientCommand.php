<?php

declare(strict_types=1);

namespace App\MessageHandler\Ingredient\Ingredient\UpdateIngredient;

use App\MessageHandler\Ingredient\Ingredient\IngredientNutritionInput;

final readonly class UpdateIngredientCommand
{
    /**
     * @param array<int> $tags
     */
    public function __construct(
        public int $id,
        public int $categoryId,
        public string $name,
        public IngredientNutritionInput $nutrition,
        public ?array $tags = null,
    ) {
    }
}
