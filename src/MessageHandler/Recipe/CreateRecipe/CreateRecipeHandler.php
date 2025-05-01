<?php

namespace App\MessageHandler\Recipe\CreateRecipe;

use App\Entity\Recipe;
use App\Repository\RecipeCategoryRepository;
use App\Repository\RecipeRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(handles: CreateRecipeCommand::class)]
class CreateRecipeHandler
{
    public function __construct(
        private RecipeRepository $recipeRepository,
        private RecipeCategoryRepository $recipeCategoryRepository,
    ) {
    }

    public function __invoke(CreateRecipeCommand $command): int
    {
        $category = $this->recipeCategoryRepository
            ->find($command->category);

        if (!$category) {
            throw new \InvalidArgumentException(sprintf('Recipe category #%d not found.', $command->category));
        }

        $recipe = new Recipe(
            name: $command->name,
            description: $command->description,
            category: $category
        );

        $this->recipeRepository->save($recipe);

        return $recipe->getId();
    }
}
