<?php

declare(strict_types=1);

namespace App\DataFixtures\Recipe;

use App\Entity\Recipe\Recipe;
use App\Entity\Recipe\RecipeCategory;
use App\Entity\Recipe\RecipeInstruction;
use App\Entity\Recipe\RecipeTag;
use App\Entity\Recipe\Utensil;
use App\Enum\DifficultyEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class RecipeFixture extends Fixture implements DependentFixtureInterface
{
    public const ORIGINAL_NAME = 'OriginalRecipe';

    public function load(ObjectManager $manager): void
    {
        /** @var RecipeCategory|null $category */
        $category = $manager->getRepository(RecipeCategory::class)
            ->findOneBy(['name' => RecipeCategoryFixture::ORIGINAL_NAME]);

        $recipe = new Recipe(
            name: self::ORIGINAL_NAME,
            category: $category,
            difficulty: DifficultyEnum::MEDIUM,
            servings: 4,
            preparationTime: 5,
            cookingTime: 10,
            note: 8
        );

        $recipeTag = $this->getReference(RecipeTagFixture::ORIGINAL_NAME, RecipeTag::class);
        $utensil = $this->getReference(UtensilFixture::ORIGINAL_NAME, Utensil::class);

        $recipe->addTag($recipeTag);
        $recipe->addUtensil($utensil);

        $instructions = [
            new RecipeInstruction(
                name: 'Préparer',
                description: 'Couper les légumes',
                recipe: $recipe,
                position: 1
            ),
            new RecipeInstruction(
                name: 'Cuire',
                description: 'Ajouter les légumes dans l\'eau bouillante',
                recipe: $recipe,
                position: 2
            ),
            new RecipeInstruction(
                name: 'Servir',
                description: 'Dresser dans les assiettes',
                recipe: $recipe,
                position: 3
            ),
            new RecipeInstruction(
                name: 'Déguster',
                description: 'Bon appétit !',
                recipe: $recipe,
                position: 4
            ),
        ];
        foreach ($instructions as $instruction) {
            $recipe->addInstruction($instruction);
        }

        $manager->persist($recipe);
        $manager->flush();

        $instructions = $recipe->getInstructions();
    }

    public function getDependencies(): array
    {
        return [
            RecipeCategoryFixture::class,
            RecipeTagFixture::class,
            UtensilFixture::class,
        ];
    }
}
