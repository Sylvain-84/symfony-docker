<?php

declare(strict_types=1);

namespace App\Controller\Recipe;

use App\Dto\Recipe\RecipeTagDto;
use App\MessageHandler\Recipe\RecipeTag\CreateRecipeTag\CreateRecipeTagCommand;
use App\MessageHandler\Recipe\RecipeTag\DeleteRecipeTag\DeleteRecipeTagCommand;
use App\MessageHandler\Recipe\RecipeTag\UpdateRecipeTag\UpdateRecipeTagCommand;
use App\Repository\Recipe\RecipeTagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/recipe_tags', name: 'recipe_tags_')]
class RecipeTagController extends AbstractController
{
    public function __construct(
        private readonly RecipeTagRepository $recipeTagRepository,
    ) {
    }

    #[Route('', name: 'index', methods: ['GET'])]
    public function getAllRecipeTags(): JsonResponse
    {
        $recipeTags = $this->recipeTagRepository->findAll();
        $recipeTagsDto = array_map(
            fn ($recipeTag) => RecipeTagDto::transform(
                $recipeTag->getName(),
                $recipeTag->getId()
            ),
            $recipeTags
        );

        return $this->json([
            'recipe_tags' => $recipeTagsDto,
        ]);
    }

    #[Route('', name: 'add', methods: ['POST'])]
    public function addRecipeTag(
        MessageBusInterface $bus,
        #[MapRequestPayload]
        CreateRecipeTagCommand $createRecipeTagCommand,
    ): JsonResponse {
        $bus->dispatch($createRecipeTagCommand);

        return $this->json([
            'message' => 'Recipe Tag added successfully',
        ]);
    }

    #[Route('/{id}', name: 'update', methods: ['PUT'], requirements: ['id' => '\d+'])]
    public function updateRecipeById(
        MessageBusInterface $bus,
        #[MapRequestPayload]
        UpdateRecipeTagCommand $updateRecipeTagCommand,
    ): JsonResponse {
        $bus->dispatch($updateRecipeTagCommand);

        return $this->json([
            'message' => 'Recipe edited successfully',
        ]);
    }

    #[Route('/{id}', name: 'delete', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function deleteRecipeTagById(
        int $id,
        MessageBusInterface $bus,
    ): JsonResponse {
        $bus->dispatch(new DeleteRecipeTagCommand($id));

        return $this->json([
            'message' => 'Recipe tag deleted successfully',
        ]);
    }
}
