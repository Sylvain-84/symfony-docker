<?php

declare(strict_types=1);

namespace App\Tests\MessageHandler\IngredientCategory;

use App\Entity\IngredientCategory;
use App\MessageHandler\IngredientCategory\CreateIngredientCategory\CreateIngredientCategoryCommand;
use App\MessageHandler\IngredientCategory\CreateIngredientCategory\CreateIngredientCategoryHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @covers \App\MessageHandler\IngredientCategory\CreateIngredientCategory\CreateIngredientCategoryHandler
 */
final class CreateIngredientCategoryHandlerTest extends KernelTestCase
{
    private EntityManagerInterface $em;
    private CreateIngredientCategoryHandler $handler;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->em = self::getContainer()->get(EntityManagerInterface::class);
        $this->handler = self::getContainer()->get(CreateIngredientCategoryHandler::class);

        // Isolation for every test: start a DB transaction and roll it back in tearDown
        $this->em->beginTransaction();
    }

    protected function tearDown(): void
    {
        $this->em->rollback();
        $this->em->close();
        parent::tearDown();
    }

    public function testItCreatesAnIngredientCategoryAndReturnsItsId(): void
    {
        $command = new CreateIngredientCategoryCommand(
            name: 'TestCategory',
        );

        $returnedId = ($this->handler)($command);

        /** @var ?IngredientCategory $ingredientCategory */
        $ingredientCategory = $this->em->getRepository(IngredientCategory::class)->find($returnedId);

        self::assertNotNull($ingredientCategory, 'Ingredient should have been persisted');
        self::assertSame('TestCategory', $ingredientCategory->getName());
    }
}
