<?php

namespace App\MessageHandler\Utensil\DeleteUtensil;

use App\Repository\UtensilRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(handles: DeleteUtensilCommand::class)]
class DeleteUtensilHandler
{
    public function __construct(
        private UtensilRepository $utensilRepository,
    ) {
    }

    public function __invoke(DeleteUtensilCommand $command): void
    {
        $recipe = $this->utensilRepository->find($command->id);
        $this->utensilRepository->remove($recipe);
    }
}
