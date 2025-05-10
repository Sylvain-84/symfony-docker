<?php

declare(strict_types=1);

namespace App\Dto\Recipe;

final readonly class RecipeInstructionDto
{
    private function __construct(
        public string $name,
        public string $description,
        public int $position,
    ) {
    }

    public static function transform(
        string $name,
        string $description,
        int $position,
    ): self {
        return new self(
            name: $name,
            description: $description,
            position: $position,
        );
    }
}
