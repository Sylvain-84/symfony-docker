<?php

namespace App\MessageHandler;

final readonly class CreateIngredientCategoryCommand
{
    public function __construct(
        public string $name,
    ) {}
}
