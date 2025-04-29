<?php

namespace App\MessageHandler\IngredientCategory\DeleteIngredientCategory;

final readonly class DeleteIngredientCategoryCommand
{
    public function __construct(
        public int $id,
    ) {}
}
