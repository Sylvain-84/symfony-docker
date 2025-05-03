<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\RecipeCategoryDto;
use App\MessageHandler\RecipeCategory\CreateRecipeCategory\CreateRecipeCategoryCommand;
use App\MessageHandler\RecipeCategory\DeleteRecipeCategory\DeleteRecipeCategoryCommand;
use App\MessageHandler\RecipeCategory\UpdateRecipeCategory\UpdateRecipeCategoryCommand;
use App\Repository\RecipeCategoryRepository;
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

    #[Route('', name: 'index', methods: ['GET'])]
    public function getAllRecipeCategories(): JsonResponse
    {
        $recipeCategories = $this->recipeCategoryRepository->findAll();
        $recipeCategoriesDto = array_map(
            fn ($recipeCategory) => RecipeCategoryDto::transform(
                $recipeCategory->getName(),
                $recipeCategory->getId()
            ),
            $recipeCategories
        );

        return $this->json([
            'recipe_categories' => $recipeCategoriesDto,
        ]);
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
