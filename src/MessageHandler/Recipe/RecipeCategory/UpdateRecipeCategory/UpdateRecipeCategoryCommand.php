<?php

declare(strict_types=1);

namespace App\MessageHandler\Recipe\RecipeCategory\UpdateRecipeCategory;

final readonly class UpdateRecipeCategoryCommand
{
    public function __construct(
        public int $id,
        public string $name,
    ) {
    }
}
