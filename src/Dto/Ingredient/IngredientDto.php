<?php

declare(strict_types=1);

// src/Dto/IngredientDto.php

namespace App\Dto\Ingredient;

use App\Dto\CategoryDto;
use App\Dto\TagDto;
use App\Entity\Ingredient\IngredientNutrition;
use App\Entity\Ingredient\IngredientTag;

final readonly class IngredientDto
{
    /**
     * @param list<TagDto   > $tags
     */
    private function __construct(
        public int $id,
        public CategoryDto $category,
        public string $name,
        public array $tags,
        public IngredientNutritionDto $nutritionals,
    ) {
    }

    /**
     * @param list<IngredientTag> $tags
     */
    public static function transform(
        int $categoryId,
        string $categoryName,
        string $name,
        int $id,
        array $tags,
        IngredientNutrition $nutrition,
    ): self {
        return new self(
            id: $id,
            category: CategoryDto::transform($categoryName, $categoryId),
            name: $name,
            tags: array_map(
                fn ($tag) => TagDto::transform(
                    name: $tag->getName(),
                    id: $tag->getId(),
                ),
                $tags
            ),
            nutritionals: IngredientNutritionDto::fromEntity($nutrition),
        );
    }
}
