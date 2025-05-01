<?php

namespace App\MessageHandler\IngredientTag\DeleteIngredientTag;

final readonly class DeleteIngredientTagCommand
{
    public function __construct(
        public int $id,
    ) {
    }
}
