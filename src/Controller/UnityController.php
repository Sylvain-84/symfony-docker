<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\UnitiesDto;
use App\Enum\UnityEnum;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/unities', name: 'unities_')]
class UnityController extends AbstractController
{
    #[Route('', name: 'get', methods: ['GET'])]
    public function getUnities(): JsonResponse
    {
        $units = array_map(
            static fn (UnityEnum $unity) => UnitiesDto::transform($unity),
            UnityEnum::cases()
        );

        return $this->json($units);
    }
}
