<?php

namespace App\MessageHandler\RecipeCategory\CreateRecipeCategory;

final readonly class CreateRecipeCategoryCommand
{
    public function __construct(
        public string $name,
    ) {
    }
}
