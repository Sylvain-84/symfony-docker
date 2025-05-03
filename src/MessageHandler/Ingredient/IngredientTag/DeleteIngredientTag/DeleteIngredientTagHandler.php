<?php

declare(strict_types=1);

namespace App\MessageHandler\Ingredient\IngredientTag\DeleteIngredientTag;

use App\Repository\Ingredient\IngredientTagRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(handles: DeleteIngredientTagCommand::class)]
class DeleteIngredientTagHandler
{
    public function __construct(
        private IngredientTagRepository $ingredientTagRepository,
    ) {
    }

    public function __invoke(DeleteIngredientTagCommand $command): void
    {
        $ingredient = $this->ingredientTagRepository->find($command->id);
        $this->ingredientTagRepository->remove($ingredient);
    }
}
