<?php

declare(strict_types=1);

namespace App\MessageHandler\Ingredient\Ingredient\UpdateIngredient;

use App\MessageHandler\Ingredient\Ingredient\IngredientMineralInput;
use App\MessageHandler\Ingredient\Ingredient\IngredientNutritionalInput;
use App\MessageHandler\Ingredient\Ingredient\IngredientVitamineInput;

final readonly class UpdateIngredientCommand
{
    /**
     * @param array<int> $tags
     */
    public function __construct(
        public int $id,
        public int $categoryId,
        public string $name,
        public IngredientNutritionalInput $nutritionals,
        public IngredientMineralInput $minerals,
        public IngredientVitamineInput $vitamines,
        public ?array $tags = null,
    ) {
    }
}
