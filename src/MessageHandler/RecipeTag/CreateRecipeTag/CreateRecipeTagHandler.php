<?php

declare(strict_types=1);

namespace App\MessageHandler\RecipeTag\CreateRecipeTag;

use App\Entity\RecipeTag;
use App\Repository\RecipeTagRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(handles: CreateRecipeTagCommand::class)]
class CreateRecipeTagHandler
{
    public function __construct(
        private RecipeTagRepository $recipeTagRepository,
    ) {
    }

    public function __invoke(CreateRecipeTagCommand $command): int
    {
        $recipeTag = new RecipeTag(
            name: $command->name,
        );

        $this->recipeTagRepository->save($recipeTag);

        return $recipeTag->getId();
    }
}
