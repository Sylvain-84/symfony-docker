<?php

namespace App\MessageHandler\Recipe\CreateRecipe;

final readonly class CreateRecipeCommand
{
    public function __construct(
        public string $name,
        public string $description,
    ) {}
}
