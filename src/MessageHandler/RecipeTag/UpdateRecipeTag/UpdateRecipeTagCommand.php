<?php

namespace App\MessageHandler\RecipeTag\UpdateRecipeTag;

final readonly class UpdateRecipeTagCommand
{
    public function __construct(
        public int $id,
        public string $name,
    ) {
    }
}
