<?php

namespace App\MessageHandler\Ingredient\UpdateIngredient;

use App\MessageHandler\Ingredient\IngredientMineralInput;
use App\MessageHandler\Ingredient\IngredientNutritionalInput;
use App\MessageHandler\Ingredient\IngredientVitamineInput;

final readonly class UpdateIngredientCommand
{
    /**
     * @param array<int> $tags
     */
    public function __construct(
        public int $id,
        public int $category,
        public string $name,
        public IngredientNutritionalInput $nutritionals,
        public IngredientMineralInput $minerals,
        public IngredientVitamineInput $vitamines,
        public ?array $tags = null,
    ) {
    }
}
