<?php

declare(strict_types=1);

namespace App\MessageHandler\Ingredient\IngredientCategory\UpdateIngredientCategory;

use App\Repository\Ingredient\IngredientCategoryRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(handles: UpdateIngredientCategoryCommand::class)]
class UpdateIngredientCategoryHandler
{
    public function __construct(
        private IngredientCategoryRepository $ingredientCategoryRepository,
    ) {
    }

    public function __invoke(UpdateIngredientCategoryCommand $command): void
    {
        $ingredientCategory = $this->ingredientCategoryRepository->find($command->id);
        if (!$ingredientCategory) {
            throw new \InvalidArgumentException(sprintf('Ingredient category #%d not found.', $command->name));
        }
        $ingredientCategory->setName($command->name);
        $this->ingredientCategoryRepository->save($ingredientCategory);
    }
}
