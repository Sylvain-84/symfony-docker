<?php

declare(strict_types=1);

namespace App\MessageHandler\Recipe\Utensil\UpdateUtensil;

use App\Repository\Recipe\UtensilRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(handles: UpdateUtensilCommand::class)]
class UpdateUtensilHandler
{
    public function __construct(
        private UtensilRepository $utensilRepository,
    ) {
    }

    public function __invoke(UpdateUtensilCommand $command): void
    {
        $utensil = $this->utensilRepository->find($command->id);
        if (!$utensil) {
            throw new \InvalidArgumentException(sprintf('Recipe tag #%d not found.', $command->name));
        }
        $utensil->setName($command->name);
        $this->utensilRepository->save($utensil);
    }
}
