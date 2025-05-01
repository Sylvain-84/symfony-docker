<?php

declare(strict_types=1);

namespace App\Tests\MessageHandler\RecipeCategory;

use App\Entity\RecipeCategory;
use App\MessageHandler\RecipeCategory\CreateRecipeCategory\CreateRecipeCategoryCommand;
use App\MessageHandler\RecipeCategory\CreateRecipeCategory\CreateRecipeCategoryHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @covers \App\MessageHandler\RecipeCategory\CreateRecipeCategory\CreateRecipeCategoryHandler
 */
final class CreateRecipeCategoryHandlerTest extends KernelTestCase
{
    private EntityManagerInterface $em;
    private CreateRecipeCategoryHandler $handler;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->em = self::getContainer()->get(EntityManagerInterface::class);
        $this->handler = self::getContainer()->get(CreateRecipeCategoryHandler::class);

        // Isolation for every test: start a DB transaction and roll it back in tearDown
        $this->em->beginTransaction();
    }

    protected function tearDown(): void
    {
        $this->em->rollback();
        $this->em->close();
        parent::tearDown();
    }

    public function testItCreatesAnRecipeCategoryAndReturnsItsId(): void
    {
        $command = new CreateRecipeCategoryCommand(
            name: 'TestCategory',
        );

        $returnedId = ($this->handler)($command);

        /** @var ?RecipeCategory $RecipeCategory */
        $RecipeCategory = $this->em->getRepository(RecipeCategory::class)->find($returnedId);

        self::assertNotNull($RecipeCategory, 'Recipe should have been persisted');
        self::assertSame('TestCategory', $RecipeCategory->getName());
    }
}
