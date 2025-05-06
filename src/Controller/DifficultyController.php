<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\DifficultyDto;
use App\Enum\DifficultyEnum;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/difficulties', name: 'difficulties_')]
class DifficultyController extends AbstractController
{
    #[Route('', name: 'get', methods: ['GET'])]
    public function getDifficulties(): JsonResponse
    {
        $difficulties = array_map(
            static fn (DifficultyEnum $difficulty) => DifficultyDto::transform($difficulty),
            DifficultyEnum::cases()
        );

        return $this->json($difficulties);
    }
}
