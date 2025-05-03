<?php

declare(strict_types=1);

namespace App\MessageHandler\Ingredient\IngredientCategory\CreateIngredientCategory;

final readonly class CreateIngredientCategoryCommand
{
    public function __construct(
        public string $name,
    ) {
    }
}
