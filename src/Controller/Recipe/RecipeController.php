<?php

declare(strict_types=1);

namespace App\Controller\Recipe;

use App\Dto\DifficultyDto;
use App\Dto\Recipe\RecipeDto;
use App\Dto\Recipe\RecipeListDto;
use App\Enum\DifficultyEnum;
use App\MessageHandler\Recipe\Recipe\CreateRecipe\CreateRecipeCommand;
use App\MessageHandler\Recipe\Recipe\DeleteRecipe\DeleteRecipeCommand;
use App\MessageHandler\Recipe\Recipe\UpdateRecipe\UpdateRecipeCommand;
use App\Repository\Recipe\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    #[Route('', name: 'index', methods: ['GET'])]
    public function getAllRecipes(): JsonResponse
    {
        $recipes = $this->recipeRepository->findAllOrderedByName();
        $recipesDto = array_map(
            fn ($recipe) => RecipeListDto::transform(
                category: $recipe->getCategory()->getName(),
                name: $recipe->getName(),
                id: $recipe->getId(),
                difficulty: $recipe->getDifficulty()->value,
                preparationTime: $recipe->getPreparationTime(),
                cookingTime: $recipe->getCookingTime(),
                note: $recipe->getNote()
            ),
            $recipes
        );

        return $this->json($recipesDto);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function getRecipeById(int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        $recipe = $this->recipeRepository->find($id);

        return $this->json(
            RecipeDto::transform(
                categoryId: $recipe->getCategory()->getId(),
                categoryName: $recipe->getCategory()->getName(),
                name: $recipe->getName(),
                description: $recipe->getDescription(),
                id: $recipe->getId(),
                difficulty: $recipe->getDifficulty()->value,
                servings: $recipe->getServings(),
                preparationTime: $recipe->getPreparationTime(),
                cookingTime: $recipe->getCookingTime(),
                note: $recipe->getNote(),
                ingredients: $recipe->getIngredients()->toArray(),
                instructions: $recipe->getInstructions()->toArray(),
                tags: $recipe->getTags()->toArray(),
                utensils: $recipe->getUtensils()->toArray(),
            ),
        );
    }

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

    #[Route('/difficulties', name: 'get_difficulties', methods: ['GET'])]
    public function getDifficulties(): JsonResponse
    {
        $difficulties = array_map(
            static fn (DifficultyEnum $difficulty) => DifficultyDto::transform($difficulty),
            DifficultyEnum::cases()
        );

        return $this->json($difficulties);
    }
}
