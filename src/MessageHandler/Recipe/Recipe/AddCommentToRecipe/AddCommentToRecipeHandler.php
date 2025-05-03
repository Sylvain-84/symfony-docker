<?php

declare(strict_types=1);

namespace App\MessageHandler\Recipe\Recipe\AddCommentToRecipe;

use App\Entity\Recipe\RecipeComment;
use App\Repository\Recipe\RecipeRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(handles: AddCommentToRecipeCommand::class)]
class AddCommentToRecipeHandler
{
    public function __construct(
        private RecipeRepository $recipeRepository,
    ) {
    }

    public function __invoke(AddCommentToRecipeCommand $command): int
    {
        $recipe = $this->recipeRepository
            ->find($command->recipeId);

        if (!$recipe) {
            throw new \InvalidArgumentException(sprintf('Recipe #%d not found.', $command->recipeId));
        }

        $comment = new RecipeComment(recipe: $recipe, comment: $command->comment);
        $recipe->addComment($comment);

        $this->recipeRepository->save($recipe);

        return $recipe->getId();
    }
}
