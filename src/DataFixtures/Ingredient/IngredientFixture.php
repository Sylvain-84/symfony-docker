<?php

declare(strict_types=1);

namespace App\DataFixtures\Ingredient;

use App\Entity\Ingredient\Ingredient;
use App\Entity\Ingredient\IngredientCategory;
use App\Entity\Ingredient\IngredientMinerals;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class IngredientFixture extends Fixture implements DependentFixtureInterface
{
    public const ORIGINAL_NAME = 'Tomate - FIXTURE';
    public const ORIGINAL_NAME_2 = 'Carotte - FIXTURE';
    public const ORIGINAL_NAME_UNUSED = 'Flocon d\'avoine - FIXTURE';

    public function load(ObjectManager $manager): void
    {
        /** @var IngredientCategory|null $category */
        $category = $manager->getRepository(IngredientCategory::class)
            ->findOneBy(['name' => IngredientCategoryFixture::ORIGINAL_NAME]);

        $ingredient = new Ingredient(
            name: self::ORIGINAL_NAME,
            category: $category,
            minerals: new IngredientMinerals()
        );

        $ingredient2 = new Ingredient(
            name: self::ORIGINAL_NAME_2,
            category: $category
        );

        $ingredient3 = new Ingredient(
            name: self::ORIGINAL_NAME_UNUSED,
            category: $category
        );

        $manager->persist($ingredient);
        $manager->persist($ingredient2);
        $manager->persist($ingredient3);

        $manager->flush();

        $this->addReference(self::ORIGINAL_NAME, $ingredient);
        $this->addReference(self::ORIGINAL_NAME_2, $ingredient2);
        $this->addReference(self::ORIGINAL_NAME_UNUSED, $ingredient3);
    }

    public function getDependencies(): array
    {
        return [
            IngredientCategoryFixture::class,
        ];
    }
}
