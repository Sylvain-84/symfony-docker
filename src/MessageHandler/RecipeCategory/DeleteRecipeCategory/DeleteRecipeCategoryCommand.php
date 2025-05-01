<?php

namespace App\MessageHandler\RecipeCategory\DeleteRecipeCategory;

final readonly class DeleteRecipeCategoryCommand
{
    public function __construct(
        public int $id,
    ) {
    }
}
