<?php

declare(strict_types=1);

// src/Dto/IngredientDto.php

namespace App\Dto\Recipe;

use App\Dto\CategoryDto;
use App\Dto\Ingredient\IngredientMineralsDto;
use App\Dto\Ingredient\IngredientNutritionalsDto;
use App\Dto\Ingredient\IngredientVitaminesDto;
use App\Dto\TagDto;
use App\Entity\Ingredient\IngredientMinerals;
use App\Entity\Ingredient\IngredientNutritionals;
use App\Entity\Ingredient\IngredientVitamines;
use App\Entity\Recipe\RecipeIngredient;
use App\Entity\Recipe\RecipeInstruction;
use App\Entity\Recipe\RecipeTag;
use App\Entity\Recipe\Utensil;

final readonly class RecipeDto
{
    /**
     * @param list<RecipeIngredientDto>  $ingredients
     * @param list<RecipeInstructionDto> $instructions
     * @param list<TagDto>               $tags
     * @param list<UtensilDto>           $utensils
     */
    private function __construct(
        public int $id,
        public CategoryDto $category,
        public string $name,
        public ?string $description,
        public string $difficulty,
        public int $servings,
        public int $preparationTime,
        public int $cookingTime,
        public ?int $note,
        public array $ingredients,
        public array $instructions,
        public array $tags,
        public array $utensils,
        public IngredientNutritionalsDto $totalNutritionals,
        public IngredientMineralsDto $totalMinerals,
        public IngredientVitaminesDto $totalVitamins,
    ) {
    }

    /**
     * @param list<RecipeIngredient>  $ingredients
     * @param list<RecipeInstruction> $instructions
     * @param list<RecipeTag>         $tags
     * @param list<Utensil>           $utensils
     */
    public static function transform(
        int $categoryId,
        string $categoryName,
        string $name,
        ?string $description,
        int $id,
        string $difficulty,
        int $servings,
        int $preparationTime,
        int $cookingTime,
        ?int $note,
        array $ingredients,
        array $instructions,
        array $tags,
        array $utensils,
        IngredientNutritionals $nutritionalsPerServing,
        IngredientMinerals $mineralsPerServing,
        IngredientVitamines $vitaminsPerServing,
    ): self {
        return new self(
            id: $id,
            category: CategoryDto::transform($categoryName, $categoryId),
            name: $name,
            description: $description,
            difficulty: $difficulty,
            servings: $servings,
            preparationTime: $preparationTime,
            cookingTime: $cookingTime,
            note: $note,
            ingredients: array_map(
                fn ($ingredient) => RecipeIngredientDto::transform(
                    id: $ingredient->getIngredient()->getId(),
                    name: $ingredient->getIngredient()->getName(),
                    quantity: $ingredient->getQuantity(),
                    unity: $ingredient->getUnit(),
                ),
                $ingredients
            ),
            instructions: array_map(
                fn ($instruction) => RecipeInstructionDto::transform(
                    name: $instruction->getName(),
                    description: $instruction->getDescription(),
                    position: $instruction->getPosition(),
                ),
                $instructions
            ),
            tags: array_map(
                fn ($tag) => TagDto::transform(
                    name: $tag->getName(),
                    id: $tag->getId(),
                ),
                $tags
            ),
            utensils: array_map(
                fn ($utensil) => UtensilDto::transform(
                    name: $utensil->getName(),
                    id: $utensil->getId(),
                ),
                $utensils
            ),
            totalNutritionals: IngredientNutritionalsDto::transform($nutritionalsPerServing),
            totalMinerals: IngredientMineralsDto::transform($mineralsPerServing),
            totalVitamins: IngredientVitaminesDto::transform($vitaminsPerServing),
        );
    }
}
