<?php

namespace App\MessageHandler\RecipeTag\CreateRecipeTag;

final readonly class CreateRecipeTagCommand
{
    public function __construct(
        public string $name,
    ) {
    }
}
