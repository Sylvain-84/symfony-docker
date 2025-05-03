<?php

declare(strict_types=1);

namespace App\Tests\MessageHandler\Ingredient\IngredientTag;

use App\Entity\Ingredient\IngredientTag;
use App\MessageHandler\Ingredient\IngredientTag\CreateIngredientTag\CreateIngredientTagCommand;
use App\MessageHandler\Ingredient\IngredientTag\CreateIngredientTag\CreateIngredientTagHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @covers \App\MessageHandler\Ingredient\IngredientTag\CreateIngredientTag\CreateIngredientTagHandler
 */
final class CreateIngredientTagHandlerTest extends KernelTestCase
{
    private EntityManagerInterface $em;
    private CreateIngredientTagHandler $handler;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->em = self::getContainer()->get(EntityManagerInterface::class);
        $this->handler = self::getContainer()->get(CreateIngredientTagHandler::class);

        // Isolation for every test: start a DB transaction and roll it back in tearDown
        $this->em->beginTransaction();
    }

    protected function tearDown(): void
    {
        $this->em->rollback();
        $this->em->close();
        parent::tearDown();
    }

    public function testItCreatesAnIngredientTagAndReturnsItsId(): void
    {
        $command = new CreateIngredientTagCommand(
            name: 'TestTag',
        );

        $returnedId = ($this->handler)($command);

        /** @var ?IngredientTag $IngredientTag */
        $IngredientTag = $this->em->getRepository(IngredientTag::class)->find($returnedId);

        self::assertNotNull($IngredientTag, 'Ingredient tag should have been persisted');
        self::assertSame('TestTag', $IngredientTag->getName());
    }
}
