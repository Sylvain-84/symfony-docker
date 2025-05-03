<?php

declare(strict_types=1);

namespace App\MessageHandler\IngredientTag\CreateIngredientTag;

final readonly class CreateIngredientTagCommand
{
    public function __construct(
        public string $name,
    ) {
    }
}
