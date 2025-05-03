<?php

declare(strict_types=1);

namespace App\Entity\Recipe;

use App\Entity\Ingredient\Ingredient;
use App\Enum\UnityEnum;
use App\Repository\Recipe\RecipeIngredientRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RecipeIngredientRepository::class)]
#[ORM\Table(name: 'recipe_ingredient')]
#[ORM\UniqueConstraint(name: 'uniq_recipe_ingredient', columns: ['recipe_id', 'ingredient_id'])]
#[UniqueEntity(
    fields: ['recipe', 'ingredient'],
    message: 'Cet ingrédient est déjà présent dans la recette.'
)]
class RecipeIngredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\ManyToOne(inversedBy: 'recipeIngredients')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Recipe $recipe;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private Ingredient $ingredient;

    #[Assert\Positive]
    #[ORM\Column(type: 'float')]
    private float $quantity;

    #[ORM\Column(enumType: UnityEnum::class)]
    private UnityEnum $unit;

    public function __construct(
        Recipe $recipe,
        Ingredient $ingredient,
        float $quantity,
        UnityEnum $unit,
    ) {
        $this->recipe = $recipe;
        $this->ingredient = $ingredient;
        $this->quantity = $quantity;
        $this->unit = $unit;
    }

    public function getUnit(): UnityEnum
    {
        return $this->unit;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function getIngredient(): Ingredient
    {
        return $this->ingredient;
    }
}
