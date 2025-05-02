<?php

namespace App\MessageHandler\Recipe\CreateRecipe;

use App\Entity\Recipe;
use App\Repository\RecipeCategoryRepository;
use App\Repository\RecipeRepository;
use App\Repository\RecipeTagRepository;
use App\Repository\UtensilRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(handles: CreateRecipeCommand::class)]
class CreateRecipeHandler
{
    public function __construct(
        private RecipeRepository $recipeRepository,
        private RecipeCategoryRepository $recipeCategoryRepository,
        private RecipeTagRepository $recipeTagRepository,
        private UtensilRepository $utensilRepository,
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
            category: $category,
            difficulty: $command->difficulty,
            servings: $command->servings,
            preparationTime: $command->preparationTime,
            cookingTime: $command->cookingTime,
            description: $command->description,
        );

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

        return $recipe->getId();
    }
}
