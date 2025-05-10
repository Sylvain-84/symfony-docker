<?php

declare(strict_types=1);

namespace App\Controller\Ingredient;

use App\Dto\CategoryDto;
use App\MessageHandler\Ingredient\IngredientCategory\CreateIngredientCategory\CreateIngredientCategoryCommand;
use App\MessageHandler\Ingredient\IngredientCategory\DeleteIngredientCategory\DeleteIngredientCategoryCommand;
use App\MessageHandler\Ingredient\IngredientCategory\UpdateIngredientCategory\UpdateIngredientCategoryCommand;
use App\Repository\Ingredient\IngredientCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/ingredient_categories', name: 'ingredient_categories_')]
class IngredientCategoryController extends AbstractController
{
    public function __construct(
        private readonly IngredientCategoryRepository $ingredientCategoryRepository,
    ) {
    }

    #[Route('/{id}', name: 'get', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function getIngredientCategoryById(
        int $id,
    ): JsonResponse {
        $ingredientCategory = $this->ingredientCategoryRepository->find($id);
        $ingredientCategoryDto = CategoryDto::transform(
            $ingredientCategory->getName(),
            $ingredientCategory->getId()
        );

        return $this->json($ingredientCategoryDto);
    }

    #[Route('', name: 'index', methods: ['GET'])]
    public function getAllIngredientCategories(): JsonResponse
    {
        $ingredientCategories = $this->ingredientCategoryRepository->findAll();
        $ingredientCategoriesDto = array_map(
            fn ($ingredientCategory) => CategoryDto::transform(
                $ingredientCategory->getName(),
                $ingredientCategory->getId()
            ),
            $ingredientCategories
        );

        return $this->json($ingredientCategoriesDto);
    }

    #[Route('', name: 'add', methods: ['POST'])]
    public function addIngredientCategory(
        MessageBusInterface $bus,
        #[MapRequestPayload]
        CreateIngredientCategoryCommand $createIngredientCategoryCommand,
    ): JsonResponse {
        $bus->dispatch($createIngredientCategoryCommand);

        return $this->json([
            'message' => 'Ingredient Category added successfully',
        ]);
    }

    #[Route('/{id}', name: 'update', methods: ['PUT'], requirements: ['id' => '\d+'])]
    public function updateIngredientCategoryById(
        MessageBusInterface $bus,
        #[MapRequestPayload]
        UpdateIngredientCategoryCommand $updateIngredientCategoryCommand,
    ): JsonResponse {
        $bus->dispatch($updateIngredientCategoryCommand);

        return $this->json([
            'message' => 'Ingredient edited successfully',
        ]);
    }

    #[Route('/{id}', name: 'delete', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function deleteIngredientCategoryById(
        int $id,
        MessageBusInterface $bus,
    ): JsonResponse {
        $bus->dispatch(new DeleteIngredientCategoryCommand($id));

        return $this->json([
            'message' => 'Ingredient category deleted successfully',
        ]);
    }
}
