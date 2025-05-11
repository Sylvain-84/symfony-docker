<?php

declare(strict_types=1);

namespace App\DataFixtures\Ingredient;

use App\Entity\Ingredient\IngredientTag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class IngredientTagFixture extends Fixture
{
    public const string ORIGINAL_NAME = 'Allergen - FIXTURE';
    public const string ORIGINAL_NAME_2 = 'Antioxidant - FIXTURE';
    public const string ORIGINAL_NAME_3 = 'Auto-immune - FIXTURE';
    public const string ORIGINAL_NAME_UNUSED = 'Rich in protein - FIXTURE';

    public function load(ObjectManager $manager): void
    {
        foreach ($this->provideData() as $name) {
            $manager->persist(new IngredientTag(name: $name));
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
