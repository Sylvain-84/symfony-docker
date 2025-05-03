<?php

declare(strict_types=1);

namespace App\Tests\MessageHandler\Recipe\RecipeTag;

use App\Entity\Recipe\RecipeTag;
use App\MessageHandler\Recipe\RecipeTag\CreateRecipeTag\CreateRecipeTagCommand;
use App\MessageHandler\Recipe\RecipeTag\CreateRecipeTag\CreateRecipeTagHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @covers \App\MessageHandler\Recipe\RecipeTag\CreateRecipeTag\CreateRecipeTagHandler
 */
final class CreateRecipeTagHandlerTest extends KernelTestCase
{
    private EntityManagerInterface $em;
    private CreateRecipeTagHandler $handler;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->em = self::getContainer()->get(EntityManagerInterface::class);
        $this->handler = self::getContainer()->get(CreateRecipeTagHandler::class);

        // Isolation for every test: start a DB transaction and roll it back in tearDown
        $this->em->beginTransaction();
    }

    protected function tearDown(): void
    {
        $this->em->rollback();
        $this->em->close();
        parent::tearDown();
    }

    public function testItCreatesAnRecipeTagAndReturnsItsId(): void
    {
        $command = new CreateRecipeTagCommand(
            name: 'TestTag',
        );

        $returnedId = ($this->handler)($command);

        /** @var ?RecipeTag $RecipeTag */
        $RecipeTag = $this->em->getRepository(RecipeTag::class)->find($returnedId);

        self::assertNotNull($RecipeTag, 'Recipe should have been persisted');
        self::assertSame('TestTag', $RecipeTag->getName());
    }
}
