<?php

namespace App\MessageHandler\IngredientCategory\UpdateIngredientCategory;

final readonly class UpdateIngredientCategoryCommand
{
    public function __construct(
        public int $id,
        public string $name,
    ) {
    }
}
