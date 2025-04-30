<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\IngredientCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class IngredientCategoryFixture extends Fixture
{
    public const ORIGINAL_NAME = 'OriginalName';

    public function load(ObjectManager $manager): void
    {
        $category = (new IngredientCategory(self::ORIGINAL_NAME));

        $manager->persist($category);
        $manager->flush();
    }
}
