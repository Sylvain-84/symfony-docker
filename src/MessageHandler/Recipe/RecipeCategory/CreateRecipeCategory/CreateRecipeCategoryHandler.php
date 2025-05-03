<?php

declare(strict_types=1);

namespace App\MessageHandler\Recipe\RecipeCategory\CreateRecipeCategory;

use App\Entity\Recipe\RecipeCategory;
use App\Repository\Recipe\RecipeCategoryRepository;
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
