<?php

namespace App\Controller;

use App\Dto\IngredientCategoryDto;
use App\MessageHandler\CreateIngredientCategory\CreateIngredientCategoryCommand;
use App\Repository\IngredientCategoryRepository;
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
    #[Route('', name: 'index', methods: ['GET'])]
    public function getAllIngredientCategories(): JsonResponse
    {
        $ingredientCategories = $this->ingredientCategoryRepository->findAll();
        $ingredientCategoriesDto = array_map(
            fn($ingredientCategory) => IngredientCategoryDto::transform(
                $ingredientCategory->getName(),
                $ingredientCategory->getId()
            ),
            $ingredientCategories
        );
        return $this->json([
            'ingredient_categories' => $ingredientCategoriesDto,
        ]);
    }

    #[Route('', name: 'add', methods: ['POST'])]
    public function addIngredientCategory(
        MessageBusInterface $bus,
        #[MapRequestPayload]
        CreateIngredientCategoryCommand $createIngredientCategoryCommand
    ): JsonResponse {
        $bus->dispatch($createIngredientCategoryCommand);

        return $this->json([
            'message' => 'Ingredient Category added successfully',
        ]);
    }
}
