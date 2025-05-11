<?php

declare(strict_types=1);

namespace App\DataFixtures\Recipe;

use App\DataFixtures\Ingredient\IngredientFixture;
use App\Entity\Ingredient\Ingredient;
use App\Entity\Recipe\Recipe;
use App\Entity\Recipe\RecipeCategory;
use App\Entity\Recipe\RecipeIngredient;
use App\Entity\Recipe\RecipeInstruction;
use App\Entity\Recipe\RecipeTag;
use App\Entity\Recipe\Utensil;
use App\Enum\DifficultyEnum;
use App\Enum\UnityEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class RecipeFixture extends Fixture implements DependentFixtureInterface
{
    public const ORIGINAL_NAME = 'Tarte aux pommes - FIXTURE';

    public function load(ObjectManager $manager): void
    {
        $category = $manager->getRepository(RecipeCategory::class)
            ->findOneBy(['name' => RecipeCategoryFixture::ORIGINAL_NAME]);

        $recipe = new Recipe(
            self::ORIGINAL_NAME,
            $category,
            DifficultyEnum::MEDIUM,
            servings: 4,
            preparationTime: 5,
            cookingTime: 10,
            note: 8
        );

        $recipe->addTag($this->getReference(RecipeTagFixture::ORIGINAL_NAME, RecipeTag::class));
        $recipe->addUtensil($this->getReference(UtensilFixture::ORIGINAL_NAME, Utensil::class));

        foreach ($this->provideIngredients($recipe) as $ri) {
            $recipe->addIngredient($ri);
        }

        foreach ($this->provideInstructions($recipe) as $instruction) {
            $recipe->addInstruction($instruction);
        }

        $manager->persist($recipe);
        $manager->flush();
    }

    /** @return iterable<RecipeIngredient> */
    private function provideIngredients(Recipe $recipe): iterable
    {
        yield new RecipeIngredient(
            $recipe,
            $this->getReference(IngredientFixture::ORIGINAL_NAME, Ingredient::class),
            150,
            UnityEnum::GRAMS
        );

        yield new RecipeIngredient(
            $recipe,
            $this->getReference(IngredientFixture::ORIGINAL_NAME_2, Ingredient::class),
            80,
            UnityEnum::GRAMS
        );
    }

    /** @return iterable<RecipeInstruction> */
    private function provideInstructions(Recipe $recipe): iterable
    {
        yield new RecipeInstruction('Préparer', 'Couper les légumes', $recipe, 1);
        yield new RecipeInstruction('Cuire', 'Ajouter les légumes à l’eau', $recipe, 2);
        yield new RecipeInstruction('Servir', 'Dresser dans les assiettes', $recipe, 3);
        yield new RecipeInstruction('Déguster', 'Bon appétit !', $recipe, 4);
    }

    public function getDependencies(): array
    {
        return [
            RecipeCategoryFixture::class,
            RecipeTagFixture::class,
            UtensilFixture::class,
            IngredientFixture::class,
        ];
    }
}
