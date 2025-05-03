<?php

declare(strict_types=1);

namespace App\MessageHandler\Recipe\Utensil\CreateUtensil;

use App\Entity\Recipe\Utensil;
use App\Repository\Recipe\UtensilRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(handles: CreateUtensilCommand::class)]
class CreateUtensilHandler
{
    public function __construct(
        private UtensilRepository $utensilRepository,
    ) {
    }

    public function __invoke(CreateUtensilCommand $command): int
    {
        $utensil = new Utensil(
            name: $command->name,
        );

        $this->utensilRepository->save($utensil);

        return $utensil->getId();
    }
}
