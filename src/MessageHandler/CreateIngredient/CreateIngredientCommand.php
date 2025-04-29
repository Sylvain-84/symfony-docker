<?php

namespace App\MessageHandler\CreateIngredient;

use App\MessageHandler\IngredientMineralInput;
use App\MessageHandler\IngredientNutritionalInput;
use App\MessageHandler\IngredientVitamineInput;

final readonly class CreateIngredientCommand
{
    public function __construct(
        public int $category,
        public string $name,
        public IngredientNutritionalInput $nutritionals,
        public IngredientMineralInput $minerals,
        public IngredientVitamineInput $vitamines,
    ) {}
}
