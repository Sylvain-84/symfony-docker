<?php

declare(strict_types=1);

namespace App\Tests\MessageHandler\Ingredient\Ingredient;

use App\DataFixtures\Ingredient\IngredientCategoryFixture;
use App\DataFixtures\Ingredient\IngredientFixture;
use App\DataFixtures\Ingredient\IngredientTagFixture;
use App\Entity\Ingredient\Ingredient;
use App\Entity\Ingredient\IngredientCategory;
use App\Entity\Ingredient\IngredientTag;
use App\MessageHandler\Ingredient\Ingredient\IngredientMineralInput;
use App\MessageHandler\Ingredient\Ingredient\IngredientNutritionalInput;
use App\MessageHandler\Ingredient\Ingredient\IngredientVitamineInput;
use App\MessageHandler\Ingredient\Ingredient\UpdateIngredient\UpdateIngredientCommand;
use App\MessageHandler\Ingredient\Ingredient\UpdateIngredient\UpdateIngredientHandler;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @covers \App\MessageHandler\Ingredient\Ingredient\UpdateIngredient\UpdateIngredientHandler
 */
final class UpdateIngredientHandlerTest extends KernelTestCase
{
    private EntityManagerInterface $em;
    private UpdateIngredientHandler $handler;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->em = self::getContainer()->get(EntityManagerInterface::class);
        $this->handler = self::getContainer()->get(UpdateIngredientHandler::class);

        // Isolation par transaction
        $this->em->beginTransaction();

        // Charge la fixture catégorie
        $loader = new Loader();
        $loader->addFixture(new IngredientCategoryFixture());
        $loader->addFixture(new IngredientFixture());

        (new ORMExecutor($this->em, new ORMPurger()))
            ->execute($loader->getFixtures(), append: true);
    }

    protected function tearDown(): void
    {
        $this->em->rollback();
        $this->em->close();
        parent::tearDown();
    }

    public function testItUpdatesAnIngredient(): void
    {
        /** @var IngredientCategory|null $category */
        $category = $this->em->getRepository(IngredientCategory::class)
            ->findOneBy(['name' => IngredientCategoryFixture::ORIGINAL_NAME]);

        self::assertNotNull($category, 'La catégorie fixture devrait exister');

        /** @var Ingredient|null $ingredient */
        $ingredient = $this->em->getRepository(Ingredient::class)
            ->findOneBy(['name' => IngredientFixture::ORIGINAL_NAME]);
        self::assertNotNull($ingredient, 'L\'ingrédient de la fixture devrait exister');

        $tag = $this->em->getRepository(IngredientTag::class)
            ->findOneBy(['name' => IngredientTagFixture::ORIGINAL_NAME]);
        $new_tag = $this->em->getRepository(IngredientTag::class)
            ->findOneBy(['name' => IngredientTagFixture::ORIGINAL_NAME_3]);

        self::assertNotNull($tag, 'Le première tag de la fixture n’a pas été trouvée');
        self::assertNotNull($new_tag, 'Le deuxième tag de la fixture n’a pas été trouvée');

        $updateCommand = new UpdateIngredientCommand(
            id: $ingredient->getId(),
            category: $category->getId(),
            name: 'Green Apple',
            nutritionals: new IngredientNutritionalInput(
                kilocalories: 52,
                proteine: 0.3,
                glucides: 13.8,
                lipides: 0.2,
                sucres: 10.4,
                fibresAlimentaires: 2.4,
                eau: 85.6,
            ),
            minerals: new IngredientMineralInput(
                calcium: 6,
                fer: 0.12,
                magnesium: 5,
                phosphore: 11,
                potassium: 107,
                sodium: 1,
                zinc: 0.04,
            ),
            vitamines: new IngredientVitamineInput(
                vitamineA: 3,
                vitamineC: 4.6,
                vitamineE: 0.18,
                vitamineK1: 2.2,
                vitamineB1: 0.017,
                vitamineB2: 0.026,
                vitamineB6: 0.041,
                vitamineB9: 0.003,   // 3 µg
            ),
            tags: [$tag->getId(), $new_tag->getId()],
        );

        ($this->handler)($updateCommand);

        /** @var Ingredient $updated */
        $updated = $this->em->getRepository(Ingredient::class)->find($ingredient->getId());

        self::assertSame('Green Apple', $updated->getName());
        self::assertSame($category->getId(), $updated->getCategory()->getId());
        self::assertSame($tag->getName(), $ingredient->getTags()->first()->getName());
        self::assertSame($new_tag->getName(), $ingredient->getTags()->get(1)->getName());
        $nutritionals = $updated->getNutritionals();
        self::assertSame(52.0, $nutritionals->getKilocalories());
        self::assertSame(0.3, $nutritionals->getProteine());
        self::assertSame(13.8, $nutritionals->getGlucides());
        self::assertSame(10.4, $nutritionals->getSucres());

        $minerals = $updated->getMinerals();
        self::assertSame(107.0, $minerals->getPotassium());
        self::assertSame(6.0, $minerals->getCalcium());

        $vitamines = $updated->getVitamines();
        self::assertSame(4.6, $vitamines->getVitamineC());
        self::assertSame(0.041, $vitamines->getVitamineB6());
    }

    public function testItThrowsWhenIngredientDoesNotExist(): void
    {
        $nonExistingId = 999_999;

        $command = new UpdateIngredientCommand(
            id: $nonExistingId,
            category: 1,
            name: 'Does not matter',
            nutritionals: new IngredientNutritionalInput(),
            minerals: new IngredientMineralInput(),
            vitamines: new IngredientVitamineInput(),
        );

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Ingredient #' . $nonExistingId . ' not found.');

        ($this->handler)($command);
    }
}
