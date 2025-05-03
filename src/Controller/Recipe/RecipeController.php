<?php

declare(strict_types=1);

namespace App\Controller\Recipe;

use App\MessageHandler\Recipe\Recipe\CreateRecipe\CreateRecipeCommand;
use App\MessageHandler\Recipe\Recipe\DeleteRecipe\DeleteRecipeCommand;
use App\MessageHandler\Recipe\Recipe\UpdateRecipe\UpdateRecipeCommand;
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

    #[Route('/{id}', name: 'update', methods: ['PUT'], requirements: ['id' => '\d+'])]
    public function updateRecipeById(
        MessageBusInterface $bus,
        #[MapRequestPayload]
        UpdateRecipeCommand $updateRecipeCommand,
    ): JsonResponse {
        $bus->dispatch($updateRecipeCommand);

        return $this->json([
            'message' => 'Recipe edited successfully',
        ]);
    }

    #[Route('/{id}', name: 'delete', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function deleteRecipeById(
        int $id,
        MessageBusInterface $bus,
    ): JsonResponse {
        $bus->dispatch(new DeleteRecipeCommand($id));

        return $this->json([
            'message' => 'Recipe deleted successfully',
        ]);
    }
}
