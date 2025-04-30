<?php
namespace App\MessageHandler\Recipe\CreateRecipe;

use App\Entity\Recipe;
use App\Repository\RecipeRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(handles: CreateRecipeCommand::class)]
class CreateRecipeHandler
{

    public function __construct(
        private RecipeRepository $recipeRepository,
        )
    {
    }

    public function __invoke(CreateRecipeCommand $command): int
    {
        $recipe = new Recipe(
            name: $command->name,
            description: $command->description,
        );

        $this->recipeRepository->save($recipe);

        return $recipe->getId();
    }
}
