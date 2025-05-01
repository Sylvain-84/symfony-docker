<?php

namespace App\MessageHandler\Recipe\CreateRecipe;

use App\Entity\Recipe;
use App\Repository\RecipeCategoryRepository;
use App\Repository\RecipeRepository;
use App\Repository\RecipeTagRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(handles: CreateRecipeCommand::class)]
class CreateRecipeHandler
{
    public function __construct(
        private RecipeRepository $recipeRepository,
        private RecipeCategoryRepository $recipeCategoryRepository,
        private RecipeTagRepository $recipeTagRepository,
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
            description: $command->description,
            difficulty: $command->difficulty,
        );

        foreach ($command->tags as $tagId) {
            $tag = $this->recipeTagRepository->find($tagId);
            if (!$tag) {
                throw new \InvalidArgumentException(sprintf('Recipe tag #%d not found.', $tagId));
            }

            $recipe->addTag($tag);
        }

        $this->recipeRepository->save($recipe);

        return $recipe->getId();
    }
}
