<?php

namespace App\MessageHandler\Recipe\UpdateRecipe;

use App\Entity\Recipe;
use App\Repository\RecipeCategoryRepository;
use App\Repository\RecipeRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(handles: UpdateRecipeCommand::class)]
class UpdateRecipeHandler
{
    public function __construct(
        private RecipeRepository $recipeRepository,
        private RecipeCategoryRepository $recipeCategoryRepository,
    ) {
    }

    public function __invoke(UpdateRecipeCommand $command): void
    {
        /** ----------------------------------------------------------------
         * 1. Fetch the recipe to update
         * ---------------------------------------------------------------- */
        $recipe = $this->recipeRepository->find($command->id);

        if (!$recipe) {
            throw new \InvalidArgumentException(sprintf('Recipe #%d not found.', $command->id));
        }

        /** ----------------------------------------------------------------
         * 2. Validate / update the category
         * ---------------------------------------------------------------- */
        $category = $this->recipeCategoryRepository->find($command->category);
        if (!$category) {
            throw new \InvalidArgumentException(sprintf('Recipe category #%d not found.', $command->category));
        }
        $recipe->setCategory($category);

        /* ----------------------------------------------------------------
         * 3. Scalar fields on Recipe
         * ---------------------------------------------------------------- */
        $recipe->setName($command->name);
        $recipe->setDescription($command->description);

        /* ----------------------------------------------------------------
         * 7. Persist & return the id
         * ---------------------------------------------------------------- */
        $this->recipeRepository->save($recipe);
    }
}
