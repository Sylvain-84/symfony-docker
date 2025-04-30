<?php

namespace App\Controller;

use App\MessageHandler\Recipe\CreateRecipe\CreateRecipeCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/recipes', name: 'recipes_')]
class RecipeController extends AbstractController
{
    #[Route('', name: 'add', methods: ['POST'])]
    public function addRecipe(
        MessageBusInterface $bus,
        #[MapRequestPayload]
        CreateRecipeCommand $createRecipeCommand,
    ): JsonResponse {
        $bus->dispatch($createRecipeCommand);

        return $this->json([
            'message' => 'Recipe added successfully',
        ]);
    }
}
