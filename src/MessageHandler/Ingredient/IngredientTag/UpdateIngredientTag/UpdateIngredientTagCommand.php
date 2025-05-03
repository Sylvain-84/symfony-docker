<?php

declare(strict_types=1);

namespace App\MessageHandler\Ingredient\IngredientTag\UpdateIngredientTag;

final readonly class UpdateIngredientTagCommand
{
    public function __construct(
        public int $id,
        public string $name,
    ) {
    }
}
