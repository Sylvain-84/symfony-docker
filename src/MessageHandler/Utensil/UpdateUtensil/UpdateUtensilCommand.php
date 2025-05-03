<?php

declare(strict_types=1);

namespace App\MessageHandler\Utensil\UpdateUtensil;

final readonly class UpdateUtensilCommand
{
    public function __construct(
        public int $id,
        public string $name,
    ) {
    }
}
