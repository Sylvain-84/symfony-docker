<?php

// src/Dto/IngredientDto.php

namespace App\Dto;

use App\Enum\UnityEnum;

final readonly class UnitiesDto
{
    private function __construct(
        public string $name,
        public string $value,
    ) {
    }

    public static function transform(UnityEnum $unity): self
    {
        return new self(
            name: $unity->name,
            value: $unity->value
        );
    }
}
