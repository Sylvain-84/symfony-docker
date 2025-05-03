<?php

declare(strict_types=1);

namespace App\MessageHandler\Utensil\CreateUtensil;

final readonly class CreateUtensilCommand
{
    public function __construct(
        public string $name,
    ) {
    }
}
