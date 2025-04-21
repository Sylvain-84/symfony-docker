<?php

namespace App\MessageHandler;

use App\Entity\Ingredient;

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
