<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Recipe;
use App\Entity\RecipeCategory;
use App\Entity\RecipeTag;
use App\Entity\Utensil;
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
            cookingTime: 10
        );

        $recipeTag = $this->getReference(RecipeTagFixture::ORIGINAL_NAME, RecipeTag::class);
        $utensil = $this->getReference(UtensilFixture::ORIGINAL_NAME, Utensil::class);

        $recipe->addTag($recipeTag);
        $recipe->addUtensil($utensil);

        $manager->persist($recipe);
        $manager->flush();
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
