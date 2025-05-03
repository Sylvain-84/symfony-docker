<?php

declare(strict_types=1);

namespace App\MessageHandler\Ingredient\IngredientCategory\DeleteIngredientCategory;

final readonly class DeleteIngredientCategoryCommand
{
    public function __construct(
        public int $id,
    ) {
    }
}
