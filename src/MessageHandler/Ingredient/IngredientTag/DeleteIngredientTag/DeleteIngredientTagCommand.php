<?php

declare(strict_types=1);

namespace App\MessageHandler\Ingredient\IngredientTag\DeleteIngredientTag;

final readonly class DeleteIngredientTagCommand
{
    public function __construct(
        public int $id,
    ) {
    }
}
