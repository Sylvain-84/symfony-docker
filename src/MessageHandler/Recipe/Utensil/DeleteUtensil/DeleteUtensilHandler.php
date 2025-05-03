<?php

declare(strict_types=1);

namespace App\MessageHandler\Recipe\Utensil\DeleteUtensil;

use App\Repository\Recipe\UtensilRepository;
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
