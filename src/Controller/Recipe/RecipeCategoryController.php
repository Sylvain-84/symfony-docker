<?php

declare(strict_types=1);

namespace App\Controller\Recipe;

use App\Dto\CategoryDto;
use App\MessageHandler\Recipe\RecipeCategory\CreateRecipeCategory\CreateRecipeCategoryCommand;
use App\MessageHandler\Recipe\RecipeCategory\DeleteRecipeCategory\DeleteRecipeCategoryCommand;
use App\MessageHandler\Recipe\RecipeCategory\UpdateRecipeCategory\UpdateRecipeCategoryCommand;
use App\Repository\Recipe\RecipeCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/recipe_categories', name: 'recipe_categories_')]
class RecipeCategoryController extends AbstractController
{
    public function __construct(
        private readonly RecipeCategoryRepository $recipeCategoryRepository,
    ) {
    }

    #[Route('/{id}', name: 'get', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function getRecipeCategoryById(
        int $id,
    ): JsonResponse {
        $recipeCategory = $this->recipeCategoryRepository->find($id);
        $recipeCategoryDto = CategoryDto::transform(
            $recipeCategory->getName(),
            $recipeCategory->getId()
        );

        return $this->json($recipeCategoryDto);
    }

    #[Route('', name: 'index', methods: ['GET'])]
    public function getAllRecipeCategories(): JsonResponse
    {
        $recipeCategories = $this->recipeCategoryRepository->findAll();
        $recipeCategoriesDto = array_map(
            fn ($recipeCategory) => CategoryDto::transform(
                $recipeCategory->getName(),
                $recipeCategory->getId()
            ),
            $recipeCategories
        );

        return $this->json($recipeCategoriesDto);
    }

    #[Route('', name: 'add', methods: ['POST'])]
    public function addRecipeCategory(
        MessageBusInterface $bus,
        #[MapRequestPayload]
        CreateRecipeCategoryCommand $createRecipeCategoryCommand,
    ): JsonResponse {
        $bus->dispatch($createRecipeCategoryCommand);

        return $this->json([
            'message' => 'Recipe Category added successfully',
        ]);
    }

    #[Route('/{id}', name: 'update', methods: ['PUT'], requirements: ['id' => '\d+'])]
    public function updateRecipeById(
        MessageBusInterface $bus,
        #[MapRequestPayload]
        UpdateRecipeCategoryCommand $updateRecipeCategoryCommand,
    ): JsonResponse {
        $bus->dispatch($updateRecipeCategoryCommand);

        return $this->json([
            'message' => 'Recipe edited successfully',
        ]);
    }

    #[Route('/{id}', name: 'delete', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function deleteRecipeCategoryById(
        int $id,
        MessageBusInterface $bus,
    ): JsonResponse {
        $bus->dispatch(new DeleteRecipeCategoryCommand($id));

        return $this->json([
            'message' => 'Recipe category deleted successfully',
        ]);
    }
}
