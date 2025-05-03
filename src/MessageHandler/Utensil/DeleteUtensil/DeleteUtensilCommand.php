<?php

declare(strict_types=1);

namespace App\MessageHandler\Utensil\DeleteUtensil;

final readonly class DeleteUtensilCommand
{
    public function __construct(
        public int $id,
    ) {
    }
}
