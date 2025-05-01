<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\RecipeTag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class RecipeTagFixture extends Fixture
{
    public const string ORIGINAL_NAME = 'OriginalName';
    public const string ORIGINAL_NAME_UNUSED = 'OriginalNameUnused';

    public function load(ObjectManager $manager): void
    {
        $tag = (new RecipeTag(
            name: self::ORIGINAL_NAME,
        ));
        $tagUnused = (new RecipeTag(
            name: self::ORIGINAL_NAME_UNUSED,
        ));

        $manager->persist($tag);
        $manager->persist($tagUnused);

        $manager->flush();
    }
}
