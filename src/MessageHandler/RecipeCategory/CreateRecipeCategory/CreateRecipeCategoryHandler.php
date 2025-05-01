<?php

namespace App\MessageHandler\RecipeCategory\CreateRecipeCategory;

use App\Entity\RecipeCategory;
use App\Repository\RecipeCategoryRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(handles: CreateRecipeCategoryCommand::class)]
class CreateRecipeCategoryHandler
{
    public function __construct(
        private RecipeCategoryRepository $recipeCategoryRepository,
    ) {
    }

    public function __invoke(CreateRecipeCategoryCommand $command): int
    {
        $recipeCategory = new RecipeCategory(
            name: $command->name,
        );

        $this->recipeCategoryRepository->save($recipeCategory);

        return $recipeCategory->getId();
    }
}
