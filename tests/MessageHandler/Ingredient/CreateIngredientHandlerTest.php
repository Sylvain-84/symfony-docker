<?php

declare(strict_types=1);

namespace App\Tests\MessageHandler\Ingredient;

use App\DataFixtures\IngredientCategoryFixture;
use App\Entity\Ingredient;
use App\Entity\IngredientCategory;
use App\MessageHandler\Ingredient\CreateIngredient\CreateIngredientCommand;
use App\MessageHandler\Ingredient\CreateIngredient\CreateIngredientHandler;
use App\MessageHandler\Ingredient\IngredientMineralInput;
use App\MessageHandler\Ingredient\IngredientNutritionalInput;
use App\MessageHandler\Ingredient\IngredientVitamineInput;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @covers \App\MessageHandler\Ingredient\CreateIngredient\CreateIngredientHandler
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

        $command = new CreateIngredientCommand(
            category: $category->getId(),
            name: 'Banana',
            nutritionals: new IngredientNutritionalInput(),
            minerals: new IngredientMineralInput(),
            vitamines: new IngredientVitamineInput(),
        );

        $returnedId = ($this->handler)($command);

        /** @var ?Ingredient $ingredient */
        $ingredient = $this->em->getRepository(Ingredient::class)->find($returnedId);

        self::assertNotNull($ingredient, 'Ingredient should have been persisted');
        self::assertSame('Banana', $ingredient->getName());
        self::assertSame($category->getId(), $ingredient->getCategory()->getId());
    }

    public function testItThrowsWhenCategoryDoesNotExist(): void
    {
        $nonExistingCategoryId = 999_999;

        $command = new CreateIngredientCommand(
            category: $nonExistingCategoryId,
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
