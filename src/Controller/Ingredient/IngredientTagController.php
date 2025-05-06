<?php

declare(strict_types=1);

namespace App\Controller\Ingredient;

use App\Dto\Ingredient\IngredientTagDto;
use App\MessageHandler\Ingredient\IngredientTag\CreateIngredientTag\CreateIngredientTagCommand;
use App\MessageHandler\Ingredient\IngredientTag\DeleteIngredientTag\DeleteIngredientTagCommand;
use App\MessageHandler\Ingredient\IngredientTag\UpdateIngredientTag\UpdateIngredientTagCommand;
use App\Repository\Ingredient\IngredientTagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/ingredient_tags', name: 'ingredient_tags_')]
class IngredientTagController extends AbstractController
{
    public function __construct(
        private readonly IngredientTagRepository $ingredientTagRepository,
    ) {
    }

    #[Route('/{id}', name: 'get', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function getIngredientTagById(
        int $id,
    ): JsonResponse {
        $ingredientTag = $this->ingredientTagRepository->find($id);
        $ingredientTagDto = IngredientTagDto::transform(
            $ingredientTag->getName(),
            $ingredientTag->getId()
        );

        return $this->json($ingredientTagDto);
    }

    #[Route('', name: 'index', methods: ['GET'])]
    public function getAllIngredientTags(): JsonResponse
    {
        $ingredientTags = $this->ingredientTagRepository->findAll();
        $ingredientTagsDto = array_map(
            fn ($ingredientTag) => IngredientTagDto::transform(
                $ingredientTag->getName(),
                $ingredientTag->getId()
            ),
            $ingredientTags
        );

        return $this->json($ingredientTagsDto);
    }

    #[Route('', name: 'add', methods: ['POST'])]
    public function addIngredientTag(
        MessageBusInterface $bus,
        #[MapRequestPayload]
        CreateIngredientTagCommand $createIngredientTagCommand,
    ): JsonResponse {
        $bus->dispatch($createIngredientTagCommand);

        return $this->json([
            'message' => 'Ingredient Tag added successfully',
        ]);
    }

    #[Route('/{id}', name: 'update', requirements: ['id' => '\d+'], methods: ['PUT'])]
    public function updateIngredientById(
        MessageBusInterface $bus,
        #[MapRequestPayload]
        UpdateIngredientTagCommand $updateIngredientTagCommand,
    ): JsonResponse {
        $bus->dispatch($updateIngredientTagCommand);

        return $this->json([
            'message' => 'Ingredient edited successfully',
        ]);
    }

    #[Route('/{id}', name: 'delete', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function deleteIngredientTagById(
        int $id,
        MessageBusInterface $bus,
    ): JsonResponse {
        $bus->dispatch(new DeleteIngredientTagCommand($id));

        return $this->json([
            'message' => 'Ingredient tag deleted successfully',
        ]);
    }
}
