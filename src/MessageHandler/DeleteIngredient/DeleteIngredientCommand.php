<?php

namespace App\MessageHandler\DeleteIngredient;

final readonly class DeleteIngredientCommand
{
    public function __construct(
        public int $id,
    ) {}
}
