<?php

declare(strict_types=1);

namespace App\MessageHandler\IngredientTag\UpdateIngredientTag;

use App\Repository\IngredientTagRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(handles: UpdateIngredientTagCommand::class)]
class UpdateIngredientTagHandler
{
    public function __construct(
        private IngredientTagRepository $ingredientTagRepository,
    ) {
    }

    public function __invoke(UpdateIngredientTagCommand $command): void
    {
        $ingredientTag = $this->ingredientTagRepository->find($command->id);
        if (!$ingredientTag) {
            throw new \InvalidArgumentException(sprintf('Ingredient tag #%d not found.', $command->name));
        }
        $ingredientTag->setName($command->name);
        $this->ingredientTagRepository->save($ingredientTag);
    }
}
