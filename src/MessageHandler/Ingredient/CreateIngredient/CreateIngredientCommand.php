<?php

declare(strict_types=1);

namespace App\MessageHandler\Ingredient\CreateIngredient;

use App\MessageHandler\Ingredient\IngredientMineralInput;
use App\MessageHandler\Ingredient\IngredientNutritionalInput;
use App\MessageHandler\Ingredient\IngredientVitamineInput;

final readonly class CreateIngredientCommand
{
    /**
     * @param array<int> $tags
     */
    public function __construct(
        public int $category,
        public string $name,
        public IngredientNutritionalInput $nutritionals,
        public IngredientMineralInput $minerals,
        public IngredientVitamineInput $vitamines,
        public ?array $tags = null,
    ) {
    }
}
