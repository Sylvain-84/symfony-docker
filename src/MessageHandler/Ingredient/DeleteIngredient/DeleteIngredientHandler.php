<?php

namespace App\MessageHandler\Ingredient\DeleteIngredient;

use App\Repository\IngredientRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(handles: DeleteIngredientCommand::class)]
class DeleteIngredientHandler
{
    public function __construct(
        private IngredientRepository $ingredientRepository,
    ) {
    }

    public function __invoke(DeleteIngredientCommand $command): void
    {
        $ingredient = $this->ingredientRepository->find($command->id);
        $this->ingredientRepository->remove($ingredient);
    }
}
