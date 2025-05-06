<?php

declare(strict_types=1);

// src/Dto/IngredientDto.php

namespace App\Dto;

use App\Enum\DifficultyEnum;

final readonly class DifficultyDto
{
    private function __construct(
        public string $name,
        public string $value,
    ) {
    }

    public static function transform(DifficultyEnum $difficulty): self
    {
        return new self(
            name: $difficulty->name,
            value: $difficulty->value
        );
    }
}
