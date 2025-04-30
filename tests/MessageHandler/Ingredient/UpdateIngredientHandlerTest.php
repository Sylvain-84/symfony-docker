<?php

declare(strict_types=1);

namespace App\Tests\MessageHandler\Ingredient;

use App\DataFixtures\IngredientCategoryFixture;
use App\DataFixtures\IngredientFixture;
use App\Entity\Ingredient;
use App\Entity\IngredientCategory;
use App\MessageHandler\Ingredient\IngredientMineralInput;
use App\MessageHandler\Ingredient\IngredientNutritionalInput;
use App\MessageHandler\Ingredient\IngredientVitamineInput;
use App\MessageHandler\Ingredient\UpdateIngredient\UpdateIngredientCommand;
use App\MessageHandler\Ingredient\UpdateIngredient\UpdateIngredientHandler;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @covers \App\MessageHandler\Ingredient\UpdateIngredient\UpdateIngredientHandler
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

        $updateCommand = new UpdateIngredientCommand(
            id: $ingredient->getId(),
            category: $category->getId(),
            name: 'Green Apple',
            nutritionals: new IngredientNutritionalInput(),
            minerals: new IngredientMineralInput(),
            vitamines: new IngredientVitamineInput(),
        );

        ($this->handler)($updateCommand);

        /** @var Ingredient $updated */
        $updated = $this->em->getRepository(Ingredient::class)->find($ingredient->getId());

        self::assertSame('Green Apple', $updated->getName());
        self::assertSame($category->getId(), $updated->getCategory()->getId());
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
