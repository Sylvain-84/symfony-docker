<?php

namespace App\MessageHandler\IngredientCategory\CreateIngredientCategory;

use App\Entity\IngredientCategory;
use App\Repository\IngredientCategoryRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(handles: CreateIngredientCategoryCommand::class)]
class CreateIngredientCategoryHandler
{
    public function __construct(
        private IngredientCategoryRepository $ingredientCategoryRepository,
    ) {
    }

    public function __invoke(CreateIngredientCategoryCommand $command): int
    {
        $ingredientCategory = new IngredientCategory(
            name: $command->name,
        );

        $this->ingredientCategoryRepository->save($ingredientCategory);

        return $ingredientCategory->getId();
    }
}
