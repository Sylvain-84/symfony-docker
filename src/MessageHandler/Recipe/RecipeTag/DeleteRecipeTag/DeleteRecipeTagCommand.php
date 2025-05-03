<?php

declare(strict_types=1);

namespace App\MessageHandler\Recipe\RecipeTag\DeleteRecipeTag;

final readonly class DeleteRecipeTagCommand
{
    public function __construct(
        public int $id,
    ) {
    }
}
