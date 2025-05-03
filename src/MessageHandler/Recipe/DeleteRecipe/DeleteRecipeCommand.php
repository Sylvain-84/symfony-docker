<?php

declare(strict_types=1);

namespace App\MessageHandler\Recipe\DeleteRecipe;

final readonly class DeleteRecipeCommand
{
    public function __construct(
        public int $id,
    ) {
    }
}
