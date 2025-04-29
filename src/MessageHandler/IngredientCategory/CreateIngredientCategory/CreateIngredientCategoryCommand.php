<?php

namespace App\MessageHandler\IngredientCategory\CreateIngredientCategory;

final readonly class CreateIngredientCategoryCommand
{
    public function __construct(
        public string $name,
    ) {}
}
