<?php

namespace App\MessageHandler\RecipeCategory\UpdateRecipeCategory;

final readonly class UpdateRecipeCategoryCommand
{
    public function __construct(
        public int $id,
        public string $name,
    ) {
    }
}
