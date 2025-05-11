<?php

declare(strict_types=1);

namespace App\DataFixtures\Ingredient;

use App\Entity\Ingredient\IngredientCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class IngredientCategoryFixture extends Fixture
{
    public const ORIGINAL_NAME = 'Fruit - FIXTURE';
    public const ORIGINAL_NAME_UNUSED = 'Legume - FIXTURE';

    public function load(ObjectManager $manager): void
    {
        $category = (new IngredientCategory(self::ORIGINAL_NAME));
        $categoryUnused = (new IngredientCategory(self::ORIGINAL_NAME_UNUSED));

        $manager->persist($category);
        $manager->persist($categoryUnused);

        $manager->flush();
    }
}
