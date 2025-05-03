<?php

declare(strict_types=1);

namespace App\MessageHandler\Recipe\RecipeCategory\CreateRecipeCategory;

final readonly class CreateRecipeCategoryCommand
{
    public function __construct(
        public string $name,
    ) {
    }
}
