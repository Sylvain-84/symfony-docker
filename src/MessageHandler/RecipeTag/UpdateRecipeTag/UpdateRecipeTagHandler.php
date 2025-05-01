<?php

namespace App\MessageHandler\RecipeTag\UpdateRecipeTag;

use App\Repository\RecipeTagRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(handles: UpdateRecipeTagCommand::class)]
class UpdateRecipeTagHandler
{
    public function __construct(
        private RecipeTagRepository $recipeTagRepository,
    ) {
    }

    public function __invoke(UpdateRecipeTagCommand $command): void
    {
        $recipeTag = $this->recipeTagRepository->find($command->id);
        if (!$recipeTag) {
            throw new \InvalidArgumentException(sprintf('Recipe tag #%d not found.', $command->name));
        }
        $recipeTag->setName($command->name);
        $this->recipeTagRepository->save($recipeTag);
    }
}
