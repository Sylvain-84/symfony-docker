<?php

namespace App\MessageHandler\Recipe\UpdateRecipe;

final readonly class UpdateRecipeCommand
{
    public function __construct(
        public int $id,
        public int $category,
        public string $name,
        public ?string $description = null,
    ) {
    }
}
