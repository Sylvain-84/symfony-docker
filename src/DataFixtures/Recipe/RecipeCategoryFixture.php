<?php

declare(strict_types=1);

namespace App\DataFixtures\Recipe;

use App\Entity\Recipe\RecipeCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class RecipeCategoryFixture extends Fixture
{
    public const ORIGINAL_NAME = 'OriginalName';
    public const ORIGINAL_NAME_UNUSED = 'OriginalNameUnused';

    public function load(ObjectManager $manager): void
    {
        $category = (new RecipeCategory(
            name: self::ORIGINAL_NAME,
        ));
        $categoryUnused = (new RecipeCategory(
            name: self::ORIGINAL_NAME_UNUSED,
        ));

        $manager->persist($category);
        $manager->persist($categoryUnused);

        $manager->flush();
    }
}
