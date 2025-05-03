<?php

declare(strict_types=1);

namespace App\MessageHandler\Ingredient\IngredientTag\CreateIngredientTag;

use App\Entity\Ingredient\IngredientTag;
use App\Repository\Ingredient\IngredientTagRepository;
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
