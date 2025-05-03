<?php

declare(strict_types=1);

namespace App\MessageHandler\Recipe\RecipeTag\UpdateRecipeTag;

use App\Repository\Recipe\RecipeTagRepository;
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
