<?php

declare(strict_types=1);

namespace App\MessageHandler\Recipe\RecipeTag\DeleteRecipeTag;

use App\Repository\Recipe\RecipeTagRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(handles: DeleteRecipeTagCommand::class)]
class DeleteRecipeTagHandler
{
    public function __construct(
        private RecipeTagRepository $recipeTagRepository,
    ) {
    }

    public function __invoke(DeleteRecipeTagCommand $command): void
    {
        $recipe = $this->recipeTagRepository->find($command->id);
        $this->recipeTagRepository->remove($recipe);
    }
}
