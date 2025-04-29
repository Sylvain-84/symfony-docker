<?php

namespace App\MessageHandler\IngredientCategory\UpdateIngredientCategory;

use App\MessageHandler\Ingredient\IngredientMineralInput;
use App\MessageHandler\Ingredient\IngredientNutritionalInput;
use App\MessageHandler\Ingredient\IngredientVitamineInput;

final readonly class UpdateIngredientCategoryCommand
{
    public function __construct(
        public int $id,
        public string $name,
    ) {}
}
