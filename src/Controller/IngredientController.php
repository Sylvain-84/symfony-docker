<?php

namespace App\Controller;

use App\Dto\IngredientDto;
use App\MessageHandler\CreateIngredientCommand;
use App\Repository\IngredientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/ingredients', name: 'ingredients_')]
class IngredientController extends AbstractController
{
    public function __construct(
        private readonly IngredientRepository $ingredientRepository
    ) {
    }
    #[Route('', name: 'index', methods: ['GET'])]
    public function getAllIngredients(): JsonResponse
    {
        $ingredients = $this->ingredientRepository->findAll();
        $ingredientsDto = array_map(
            fn($ingredient) => IngredientDto::transform(
                $ingredient->getCategory()->getId(),
                $ingredient->getName(),
                $ingredient->getId()
            ),
            $ingredients
        );
        return $this->json([
            'ingredients' => $ingredientsDto,
        ]);
    }

    #[Route('', name: 'add', methods: ['POST'])]
    public function addIngredient(
        Request $request,
        MessageBusInterface $bus,
        #[MapRequestPayload]
        CreateIngredientCommand $createIngredientCommand
    ): JsonResponse {
        $bus->dispatch($createIngredientCommand);
        
        return $this->json([
            'message' => 'Ingredient added successfully',
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function getIngredientById(int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        $ingredient = $this->ingredientRepository->find($id);

        return $this->json([
            IngredientDto::transform(
                $ingredient->getCategory()->getId(),
                $ingredient->getName(),
                $ingredient->getId()
            ),
        ]);
    }

    #[Route('/{id}', name: 'update', methods: ['PUT'], requirements: ['id' => '\d+'])]
    public function updateIngredientById(int $id, Request $request): JsonResponse
    {
        return $this->json([
            'message' => 'Ingredient edited successfully',
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'], requirements: ['id' => '\d+'])]
    public function deleteIngredientById(int $id): JsonResponse
    {
        $ingredient = $this->ingredientRepository->find($id);
        $this->ingredientRepository->remove($ingredient);

        return $this->json([
            'message' => 'Ingredient deleted successfully',
        ]);
    }
}
