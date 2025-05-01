<?php

namespace App\MessageHandler\IngredientTag\UpdateIngredientTag;

final readonly class UpdateIngredientTagCommand
{
    public function __construct(
        public int $id,
        public string $name,
    ) {
    }
}
