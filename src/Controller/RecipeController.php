<?php

namespace App\Controller;

use App\MessageHandler\Recipe\CreateRecipe\CreateRecipeCommand;
use App\Repository\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/recipes', name: 'recipes_')]
class RecipeController extends AbstractController
{
    public function __construct(
        private readonly RecipeRepository $recipeRepository,
    ) {
    }

    #[Route('', name: 'add', methods: ['POST'])]
    public function addRecipe(
        MessageBusInterface $bus,
        #[MapRequestPayload]
        CreateRecipeCommand $createRecipeCommand
    ): JsonResponse {
        $bus->dispatch($createRecipeCommand);

        return $this->json([
            'message' => 'Recipe added successfully',
        ]);
    }
}
