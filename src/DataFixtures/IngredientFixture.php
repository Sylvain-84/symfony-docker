<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Ingredient;
use App\Entity\IngredientCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class IngredientFixture extends Fixture implements DependentFixtureInterface
{
    public const ORIGINAL_NAME = 'OriginalIngredient';

    public function load(ObjectManager $manager): void
    {
        /** @var IngredientCategory|null $category */
        $category = $manager->getRepository(IngredientCategory::class)
            ->findOneBy(['name' => IngredientCategoryFixture::ORIGINAL_NAME]);

        $ingredient = new Ingredient(
            name: self::ORIGINAL_NAME,
            category: $category
        );

        $manager->persist($ingredient);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            IngredientCategoryFixture::class,
        ];
    }
}
