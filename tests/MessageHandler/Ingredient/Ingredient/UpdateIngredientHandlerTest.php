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
            nutritionals: new IngredientNutritionalInput(),
            minerals: new IngredientMineralInput(),
            vitamines: new IngredientVitamineInput(),
            tags: [$tag->getId(), $new_tag->getId()],
        );

        ($this->handler)($updateCommand);

        /** @var Ingredient $updated */
        $updated = $this->em->getRepository(Ingredient::class)->find($ingredient->getId());

        self::assertSame('Green Apple', $updated->getName());
        self::assertSame($category->getId(), $updated->getCategory()->getId());
        self::assertSame($tag->getName(), $ingredient->getTags()->first()->getName());
        self::assertSame($new_tag->getName(), $ingredient->getTags()->get(1)->getName());
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
