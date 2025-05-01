<?php

namespace App\MessageHandler\RecipeCategory\UpdateRecipeCategory;

use App\Repository\RecipeCategoryRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(handles: UpdateRecipeCategoryCommand::class)]
class UpdateRecipeCategoryHandler
{
    public function __construct(
        private RecipeCategoryRepository $recipeCategoryRepository,
    ) {
    }

    public function __invoke(UpdateRecipeCategoryCommand $command): void
    {
        $recipeCategory = $this->recipeCategoryRepository->find($command->id);
        if (!$recipeCategory) {
            throw new \InvalidArgumentException(sprintf('Recipe category #%d not found.', $command->name));
        }
        $recipeCategory->setName($command->name);
        $this->recipeCategoryRepository->save($recipeCategory);
    }
}
