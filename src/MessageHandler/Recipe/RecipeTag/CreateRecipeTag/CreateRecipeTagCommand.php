<?php

declare(strict_types=1);

namespace App\MessageHandler\Recipe\RecipeTag\CreateRecipeTag;

final readonly class CreateRecipeTagCommand
{
    public function __construct(
        public string $name,
    ) {
    }
}
