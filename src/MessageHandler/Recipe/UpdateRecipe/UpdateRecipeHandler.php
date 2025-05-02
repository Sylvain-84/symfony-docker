<?php

namespace App\MessageHandler\Recipe\UpdateRecipe;

use App\Repository\RecipeCategoryRepository;
use App\Repository\RecipeRepository;
use App\Repository\RecipeTagRepository;
use App\Repository\UtensilRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(handles: UpdateRecipeCommand::class)]
class UpdateRecipeHandler
{
    public function __construct(
        private RecipeRepository $recipeRepository,
        private RecipeCategoryRepository $recipeCategoryRepository,
        private RecipeTagRepository $recipeTagRepository,
        private UtensilRepository $utensilRepository,
    ) {
    }

    public function __invoke(UpdateRecipeCommand $command): void
    {
        $recipe = $this->recipeRepository->find($command->id);

        if (!$recipe) {
            throw new \InvalidArgumentException(sprintf('Recipe #%d not found.', $command->id));
        }

        $category = $this->recipeCategoryRepository->find($command->category);
        if (!$category) {
            throw new \InvalidArgumentException(sprintf('Recipe category #%d not found.', $command->category));
        }
        $recipe->setCategory($category);
        $recipe->setName($command->name);
        $recipe->setDescription($command->description);
        $recipe->setDifficulty($command->difficulty);
        $recipe->setServings($command->servings);
        $recipe->setPreparationTime($command->preparationTime);
        $recipe->setCookingTime($command->cookingTime);
        $recipe->setNote($command->note);

        foreach ($command->tags as $tagId) {
            $tag = $this->recipeTagRepository->find($tagId);
            if (!$tag) {
                throw new \InvalidArgumentException(sprintf('Recipe tag #%d not found.', $tagId));
            }

            $recipe->addTag($tag);
        }

        foreach ($command->utensils as $utensilId) {
            $utensil = $this->utensilRepository->find($utensilId);
            if (!$utensil) {
                throw new \InvalidArgumentException(sprintf('Utensil #%d not found.', $utensilId));
            }

            $recipe->addUtensil($utensil);
        }

        $this->recipeRepository->save($recipe);
    }
}
