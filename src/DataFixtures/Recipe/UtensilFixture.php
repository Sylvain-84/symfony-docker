<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Recipe\Utensil;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class UtensilFixture extends Fixture
{
    public const string ORIGINAL_NAME = 'OriginalName';
    public const string ORIGINAL_NAME_2 = 'OriginalNameTwo';
    public const string ORIGINAL_NAME_3 = 'OriginalNameThree';
    public const string ORIGINAL_NAME_UNUSED = 'OriginalNameUnused';

    public function load(ObjectManager $manager): void
    {
        foreach ($this->provideData() as $name) {
            $utensil = new Utensil(name: $name);
            $manager->persist($utensil);

            $this->addReference($name, $utensil);
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
