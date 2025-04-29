<?php

namespace App\MessageHandler\Ingredient\DeleteIngredient;

final readonly class DeleteIngredientCommand
{
    public function __construct(
        public int $id,
    ) {}
}
