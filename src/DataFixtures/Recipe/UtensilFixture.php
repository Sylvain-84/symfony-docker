<?php

declare(strict_types=1);

namespace App\DataFixtures\Recipe;

use App\Entity\Recipe\Utensil;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class UtensilFixture extends Fixture
{
    public const string ORIGINAL_NAME = 'Knife - FIXTURE';
    public const string ORIGINAL_NAME_2 = 'Spoon - FIXTURE';
    public const string ORIGINAL_NAME_3 = 'Frypan - FIXTURE';
    public const string ORIGINAL_NAME_UNUSED = 'Bowl - FIXTURE';

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
