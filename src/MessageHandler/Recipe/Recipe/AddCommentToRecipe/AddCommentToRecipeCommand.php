<?php

declare(strict_types=1);

namespace App\MessageHandler\Recipe\Recipe\AddCommentToRecipe;

final readonly class AddCommentToRecipeCommand
{
    public function __construct(
        public int $recipeId,
        public string $comment,
    ) {
    }
}
