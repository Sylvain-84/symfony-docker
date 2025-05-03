<?php

declare(strict_types=1);

namespace App\MessageHandler\IngredientCategory\UpdateIngredientCategory;

final readonly class UpdateIngredientCategoryCommand
{
    public function __construct(
        public int $id,
        public string $name,
    ) {
    }
}
