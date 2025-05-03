<?php

declare(strict_types=1);

namespace App\MessageHandler\Recipe\RecipeCategory\DeleteRecipeCategory;

use App\Repository\Recipe\RecipeCategoryRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(handles: DeleteRecipeCategoryCommand::class)]
class DeleteRecipeCategoryHandler
{
    public function __construct(
        private RecipeCategoryRepository $recipeCategoryRepository,
    ) {
    }

    public function __invoke(DeleteRecipeCategoryCommand $command): void
    {
        $recipe = $this->recipeCategoryRepository->find($command->id);
        $this->recipeCategoryRepository->remove($recipe);
    }
}
