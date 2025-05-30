<?php

declare(strict_types=1);

namespace App\MessageHandler\Recipe\Recipe\UpdateRecipe;

use App\Entity\Recipe\Recipe;
use App\Entity\Recipe\RecipeIngredient;
use App\Entity\Recipe\RecipeInstruction;
use App\Repository\Ingredient\IngredientRepository;
use App\Repository\Recipe\RecipeCategoryRepository;
use App\Repository\Recipe\RecipeRepository;
use App\Repository\Recipe\RecipeTagRepository;
use App\Repository\Recipe\UtensilRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(handles: UpdateRecipeCommand::class)]
class UpdateRecipeHandler
{
    public function __construct(
        private RecipeRepository $recipeRepository,
        private RecipeCategoryRepository $recipeCategoryRepository,
        private RecipeTagRepository $recipeTagRepository,
        private UtensilRepository $utensilRepository,
        private IngredientRepository $ingredientRepository,
    ) {
    }

    public function __invoke(UpdateRecipeCommand $command): void
    {
        $recipe = $this->recipeRepository->find($command->id);

        if (!$recipe) {
            throw new \InvalidArgumentException(sprintf('Recipe #%d not found.', $command->id));
        }

        $category = $this->recipeCategoryRepository->find($command->categoryId);
        if (!$category) {
            throw new \InvalidArgumentException(sprintf('Recipe category #%d not found.', $command->categoryId));
        }
        $recipe->setCategory($category);
        $recipe->setName($command->name);
        $recipe->setDescription($command->description);
        $recipe->setDifficulty($command->difficulty);
        $recipe->setServings($command->servings);
        $recipe->setPreparationTime($command->preparationTime);
        $recipe->setCookingTime($command->cookingTime);
        $recipe->setNote($command->note);

        $recipe = $this->tags($command, $recipe);
        $recipe = $this->utensils($command, $recipe);
        $recipe = $this->instructions($command, $recipe);
        $recipe = $this->ingredients($command, $recipe);

        $this->recipeRepository->save($recipe);
    }

    private function tags(UpdateRecipeCommand $command, Recipe $recipe): Recipe
    {
        $recipe->clearTags();

        if (null !== $command->tags) {
            foreach ($command->tags as $tagId) {
                $tag = $this->recipeTagRepository->find($tagId);
                if (!$tag) {
                    throw new \InvalidArgumentException(sprintf('Recipe tag #%d not found.', $tagId));
                }

                $recipe->addTag($tag);
            }
        }

        return $recipe;
    }

    private function utensils(UpdateRecipeCommand $command, Recipe $recipe): Recipe
    {
        $recipe->clearUtensils();

        if (null !== $command->utensils) {
            foreach ($command->utensils as $utensilId) {
                $utensil = $this->utensilRepository->find($utensilId);
                if (!$utensil) {
                    throw new \InvalidArgumentException(sprintf('Utensil #%d not found.', $utensilId));
                }

                $recipe->addUtensil($utensil);
            }
        }

        return $recipe;
    }

    private function instructions(UpdateRecipeCommand $command, Recipe $recipe): Recipe
    {
        $recipe->clearInstructions();

        if (null !== $command->instructions) {
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
        }

        return $recipe;
    }

    private function ingredients(UpdateRecipeCommand $command, Recipe $recipe): Recipe
    {
        $recipe->clearRecipeIngredients();

        foreach ($command->ingredients as $ingredientInput) {
            $ingredient = $this->ingredientRepository->find($ingredientInput->id);
            if (!$ingredient) {
                throw new \InvalidArgumentException("Ingredient #{$ingredientInput->id} not found.");
            }

            $recipe->addIngredient(
                new RecipeIngredient(
                    recipe: $recipe,
                    ingredient: $ingredient,
                    quantity: $ingredientInput->quantity,
                    unit: $ingredientInput->unity,
                )
            );
        }

        return $recipe;
    }
}
