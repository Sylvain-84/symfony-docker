<?php

declare(strict_types=1);

namespace App\MessageHandler\Recipe\RecipeCategory\DeleteRecipeCategory;

final readonly class DeleteRecipeCategoryCommand
{
    public function __construct(
        public int $id,
    ) {
    }
}
