<?php

declare(strict_types=1);

namespace App\MessageHandler\Ingredient\DeleteIngredient;

final readonly class DeleteIngredientCommand
{
    public function __construct(
        public int $id,
    ) {
    }
}
