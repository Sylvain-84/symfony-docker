<?php

namespace App\MessageHandler\Utensil\CreateUtensil;

use App\Entity\Utensil;
use App\Repository\UtensilRepository;
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
