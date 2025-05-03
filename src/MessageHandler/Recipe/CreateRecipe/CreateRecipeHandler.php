<?php

declare(strict_types=1);

namespace App\MessageHandler\Recipe\CreateRecipe;

use App\Entity\Recipe;
use App\Entity\RecipeInstruction;
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
            note: $command->note,
        );

        $recipe = $this->tags($command, $recipe);
        $recipe = $this->utensils($command, $recipe);
        $recipe = $this->instructions($command, $recipe);

        $this->recipeRepository->save($recipe);

        return $recipe->getId();
    }

    private function tags(CreateRecipeCommand $command, Recipe $recipe): Recipe
    {
        foreach ($command->tags as $tagId) {
            $tag = $this->recipeTagRepository->find($tagId);
            if (!$tag) {
                throw new \InvalidArgumentException(sprintf('Recipe tag #%d not found.', $tagId));
            }

            $recipe->addTag($tag);
        }

        return $recipe;
    }

    private function utensils(CreateRecipeCommand $command, Recipe $recipe): Recipe
    {
        foreach ($command->utensils as $utensilId) {
            $utensil = $this->utensilRepository->find($utensilId);
            if (!$utensil) {
                throw new \InvalidArgumentException(sprintf('Utensil #%d not found.', $utensilId));
            }

            $recipe->addUtensil($utensil);
        }

        return $recipe;
    }

    private function instructions(CreateRecipeCommand $command, Recipe $recipe): Recipe
    {
        foreach ($command->instructions as $instruction) {
            $recipe->addInstruction(
                new RecipeInstruction(
                    name: $instruction->name,
                    description: $instruction->description,
                    recipe: $recipe,
                    position: $instruction->position,
                )
            );
        }

        return $recipe;
    }
}
