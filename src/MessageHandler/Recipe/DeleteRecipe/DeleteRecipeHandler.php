<?php

declare(strict_types=1);

namespace App\MessageHandler\Recipe\DeleteRecipe;

use App\Repository\RecipeRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(handles: DeleteRecipeCommand::class)]
class DeleteRecipeHandler
{
    public function __construct(
        private RecipeRepository $recipeRepository,
    ) {
    }

    public function __invoke(DeleteRecipeCommand $command): void
    {
        $recipe = $this->recipeRepository->find($command->id);
        $this->recipeRepository->remove($recipe);
    }
}
