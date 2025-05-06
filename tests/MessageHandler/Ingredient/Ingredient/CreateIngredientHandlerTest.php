<?php

declare(strict_types=1);

namespace App\Tests\MessageHandler\Ingredient\Ingredient;

use App\DataFixtures\Ingredient\IngredientCategoryFixture;
use App\DataFixtures\Ingredient\IngredientTagFixture;
use App\Entity\Ingredient\Ingredient;
use App\Entity\Ingredient\IngredientCategory;
use App\Entity\Ingredient\IngredientTag;
use App\MessageHandler\Ingredient\Ingredient\CreateIngredient\CreateIngredientCommand;
use App\MessageHandler\Ingredient\Ingredient\CreateIngredient\CreateIngredientHandler;
use App\MessageHandler\Ingredient\Ingredient\IngredientMineralInput;
use App\MessageHandler\Ingredient\Ingredient\IngredientNutritionalInput;
use App\MessageHandler\Ingredient\Ingredient\IngredientVitamineInput;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @covers \App\MessageHandler\Ingredient\Ingredient\CreateIngredient\CreateIngredientHandler
 */
final class CreateIngredientHandlerTest extends KernelTestCase
{
    private EntityManagerInterface $em;
    private CreateIngredientHandler $handler;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->em = self::getContainer()->get(EntityManagerInterface::class);
        $this->handler = self::getContainer()->get(CreateIngredientHandler::class);

        // Isolation for every test: start a DB transaction and roll it back in tearDown
        $this->em->beginTransaction();
    }

    protected function tearDown(): void
    {
        $this->em->rollback();
        $this->em->close();
        parent::tearDown();
    }

    public function testItCreatesAnIngredientAndReturnsItsId(): void
    {
        /** @var ?IngredientCategory $category */
        $category = $this->em->getRepository(IngredientCategory::class)
            ->findOneBy(['name' => IngredientCategoryFixture::ORIGINAL_NAME]);

        self::assertNotNull($category, 'La catégorie de la fixture n’a pas été trouvée');

        $tag = $this->em->getRepository(IngredientTag::class)
            ->findOneBy(['name' => IngredientTagFixture::ORIGINAL_NAME]);
        $tag2 = $this->em->getRepository(IngredientTag::class)
            ->findOneBy(['name' => IngredientTagFixture::ORIGINAL_NAME_2]);

        self::assertNotNull($tag, 'Le première tag de la fixture n’a pas été trouvée');
        self::assertNotNull($tag2, 'Le deuxième tag de la fixture n’a pas été trouvée');

        $command = new CreateIngredientCommand(
            categoryId: $category->getId(),
            name: 'Banana',
            nutritionals: new IngredientNutritionalInput(
                kilocalories: 89,
                proteine: 1.1,
                glucides: 22.8,
                lipides: 0.3,
                sucres: 12.2,
                fibresAlimentaires: 2.6,
            ),
            minerals: new IngredientMineralInput(
                magnesium: 27,
                phosphore: 22,
                potassium: 358,
            ),
            vitamines: new IngredientVitamineInput(
                vitamineC: 8.7,
                vitamineB6: 0.4,
                vitamineB9: 0.02,
            ),
            tags: [$tag->getId(), $tag2->getId()],
        );

        $returnedId = ($this->handler)($command);

        /** @var ?Ingredient $ingredient */
        $ingredient = $this->em->getRepository(Ingredient::class)->find($returnedId);

        self::assertNotNull($ingredient, 'Ingredient should have been persisted');
        self::assertSame('Banana', $ingredient->getName());
        self::assertSame($category->getId(), $ingredient->getCategory()->getId());
        self::assertSame($tag->getName(), $ingredient->getTags()->first()->getName());
        self::assertSame($tag2->getName(), $ingredient->getTags()->get(1)->getName());
        self::assertSame(89.0, $ingredient->getNutritionals()->getKilocalories());
        self::assertSame(1.1, $ingredient->getNutritionals()->getProteine());
        self::assertSame(358.0, $ingredient->getMinerals()->getPotassium());
        self::assertSame(8.7, $ingredient->getVitamines()->getVitamineC());
    }

    public function testItThrowsWhenCategoryDoesNotExist(): void
    {
        $nonExistingCategoryId = 999_999;

        $command = new CreateIngredientCommand(
            categoryId: $nonExistingCategoryId,
            name: 'Mango',
            nutritionals: new IngredientNutritionalInput(),
            minerals: new IngredientMineralInput(),
            vitamines: new IngredientVitamineInput(),
        );

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Ingredient category #' . $nonExistingCategoryId . ' not found.');

        ($this->handler)($command);
    }
}
