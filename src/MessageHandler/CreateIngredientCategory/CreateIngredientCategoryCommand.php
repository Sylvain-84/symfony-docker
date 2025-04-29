<?php

namespace App\MessageHandler\CreateIngredientCategory;

final readonly class CreateIngredientCategoryCommand
{
    public function __construct(
        public string $name,
    ) {}
}
