<?php

declare(strict_types=1);

// src/Dto/IngredientDto.php

namespace App\Dto\Ingredient;

use App\Entity\Ingredient\IngredientMinerals;
use App\Entity\Ingredient\IngredientNutritionals;
use App\Entity\Ingredient\IngredientTag;
use App\Entity\Ingredient\IngredientVitamines;

final readonly class IngredientDto
{
    /**
     * @param list<int> $tags
     */
    private function __construct(
        public int $id,
        public int $categoryId,
        public string $name,
        public array $tags,
        public IngredientMineralsDto $minerals,
        public IngredientVitaminesDto $vitamines,
        public IngredientNutritionalsDto $nutritionals,
    ) {
    }

    /**
     * @param list<IngredientTag> $tags
     */
    public static function transform(
        int $categoryId,
        string $name,
        int $id,
        array $tags,
        IngredientMinerals $minerals,
        IngredientVitamines $vitamines,
        IngredientNutritionals $nutritionals,
    ): self {
        return new self(
            id: $id,
            categoryId: $categoryId,
            name: $name,
            tags: array_map(
                fn ($tag) => $tag->getId(),
                $tags
            ),
            minerals: IngredientMineralsDto::transform($minerals),
            vitamines: IngredientVitaminesDto::transform($vitamines),
            nutritionals: IngredientNutritionalsDto::transform($nutritionals),
        );
    }
}
