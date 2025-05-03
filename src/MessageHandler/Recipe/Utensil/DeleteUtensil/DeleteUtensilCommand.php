<?php

declare(strict_types=1);

namespace App\MessageHandler\Recipe\Utensil\DeleteUtensil;

final readonly class DeleteUtensilCommand
{
    public function __construct(
        public int $id,
    ) {
    }
}
