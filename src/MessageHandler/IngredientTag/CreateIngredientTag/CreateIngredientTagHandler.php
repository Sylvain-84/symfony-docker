<?php

namespace App\MessageHandler\IngredientTag\CreateIngredientTag;

use App\Entity\IngredientTag;
use App\Repository\IngredientTagRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(handles: CreateIngredientTagCommand::class)]
class CreateIngredientTagHandler
{
    public function __construct(
        private IngredientTagRepository $ingredientTagRepository,
    ) {
    }

    public function __invoke(CreateIngredientTagCommand $command): int
    {
        $ingredientTag = new IngredientTag(
            name: $command->name,
        );

        $this->ingredientTagRepository->save($ingredientTag);

        return $ingredientTag->getId();
    }
}
