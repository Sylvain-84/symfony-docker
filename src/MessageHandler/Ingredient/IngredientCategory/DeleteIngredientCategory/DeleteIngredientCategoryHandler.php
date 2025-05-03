<?php

declare(strict_types=1);

namespace App\MessageHandler\Ingredient\IngredientCategory\DeleteIngredientCategory;

use App\Repository\Ingredient\IngredientCategoryRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(handles: DeleteIngredientCategoryCommand::class)]
class DeleteIngredientCategoryHandler
{
    public function __construct(
        private IngredientCategoryRepository $ingredientCategoryRepository,
    ) {
    }

    public function __invoke(DeleteIngredientCategoryCommand $command): void
    {
        $ingredient = $this->ingredientCategoryRepository->find($command->id);
        $this->ingredientCategoryRepository->remove($ingredient);
    }
}
