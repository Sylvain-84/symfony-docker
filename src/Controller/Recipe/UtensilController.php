<?php

declare(strict_types=1);

namespace App\Controller\Recipe;

use App\Dto\Recipe\UtensilDto;
use App\MessageHandler\Recipe\Utensil\CreateUtensil\CreateUtensilCommand;
use App\MessageHandler\Recipe\Utensil\DeleteUtensil\DeleteUtensilCommand;
use App\MessageHandler\Recipe\Utensil\UpdateUtensil\UpdateUtensilCommand;
use App\Repository\Recipe\UtensilRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/utensils', name: 'recipe_tags_')]
class UtensilController extends AbstractController
{
    public function __construct(
        private readonly UtensilRepository $utensilRepository,
    ) {
    }

    #[Route('', name: 'index', methods: ['GET'])]
    public function getAllUtensils(): JsonResponse
    {
        $utensils = $this->utensilRepository->findAll();
        $utensilsDto = array_map(
            fn ($utensil) => UtensilDto::transform(
                $utensil->getName(),
                $utensil->getId()
            ),
            $utensils
        );

        return $this->json([
            'recipe_tags' => $utensilsDto,
        ]);
    }

    #[Route('', name: 'add', methods: ['POST'])]
    public function addUtensil(
        MessageBusInterface $bus,
        #[MapRequestPayload]
        CreateUtensilCommand $createUtensilCommand,
    ): JsonResponse {
        $bus->dispatch($createUtensilCommand);

        return $this->json([
            'message' => 'Recipe Tag added successfully',
        ]);
    }

    #[Route('/{id}', name: 'update', methods: ['PUT'], requirements: ['id' => '\d+'])]
    public function updateRecipeById(
        MessageBusInterface $bus,
        #[MapRequestPayload]
        UpdateUtensilCommand $updateUtensilCommand,
    ): JsonResponse {
        $bus->dispatch($updateUtensilCommand);

        return $this->json([
            'message' => 'Recipe edited successfully',
        ]);
    }

    #[Route('/{id}', name: 'delete', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function deleteUtensilById(
        int $id,
        MessageBusInterface $bus,
    ): JsonResponse {
        $bus->dispatch(new DeleteUtensilCommand($id));

        return $this->json([
            'message' => 'Recipe tag deleted successfully',
        ]);
    }
}
