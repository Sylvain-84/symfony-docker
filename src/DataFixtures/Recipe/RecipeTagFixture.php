<?php

declare(strict_types=1);

namespace App\DataFixtures\Recipe;

use App\Entity\Recipe\RecipeTag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class RecipeTagFixture extends Fixture
{
    public const string ORIGINAL_NAME = 'Rich in protein - FIXTURE';
    public const string ORIGINAL_NAME_2 = 'Allergen - FIXTURE';
    public const string ORIGINAL_NAME_3 = 'Vegan - FIXTURE';
    public const string ORIGINAL_NAME_UNUSED = 'Auto-immune - FIXTURE';

    public function load(ObjectManager $manager): void
    {
        foreach ($this->provideData() as $name) {
            $recipeTag = new RecipeTag(name: $name);
            $manager->persist($recipeTag);

            $this->addReference($name, $recipeTag);
        }

        $manager->flush();
    }

    /**
     * @return iterable<string>
     */
    private function provideData(): iterable
    {
        yield self::ORIGINAL_NAME;
        yield self::ORIGINAL_NAME_2;
        yield self::ORIGINAL_NAME_3;
        yield self::ORIGINAL_NAME_UNUSED;
    }
}
