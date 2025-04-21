<?php

namespace App\MessageHandler;

final readonly class CreateIngredientCommand
{
    public function __construct(public int $categoryId, public string $name)
    {
    }
}