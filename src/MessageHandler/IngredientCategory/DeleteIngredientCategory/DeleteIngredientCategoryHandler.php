<?php
namespace App\MessageHandler\IngredientCategory\DeleteIngredientCategory;

use App\MessageHandler\Ingredient\DeleteIngredient\DeleteIngredientCommand;
use App\Repository\IngredientCategoryRepository;
use App\Repository\IngredientRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(handles: DeleteIngredientCategoryCommand::class)]
class DeleteIngredientCategoryHandler
{

    public function __construct(
        private IngredientCategoryRepository $ingredientCategoryRepository,
        )
    {
    }

    public function __invoke(DeleteIngredientCategoryCommand $command): void
    {
        $ingredient = $this->ingredientCategoryRepository->find($command->id);
        $this->ingredientCategoryRepository->remove($ingredient);
    }
}
