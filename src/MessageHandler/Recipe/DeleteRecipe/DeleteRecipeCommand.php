<?php

namespace App\MessageHandler\Recipe\DeleteRecipe;

final readonly class DeleteRecipeCommand
{
    public function __construct(
        public int $id,
    ) {
    }
}
