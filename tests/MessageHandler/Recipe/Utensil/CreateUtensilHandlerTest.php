<?php

declare(strict_types=1);

namespace App\Tests\MessageHandler\Recipe\Utensil;

use App\Entity\Recipe\Utensil;
use App\MessageHandler\Recipe\Utensil\CreateUtensil\CreateUtensilCommand;
use App\MessageHandler\Recipe\Utensil\CreateUtensil\CreateUtensilHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @covers \App\MessageHandler\Recipe\Utensil\CreateUtensil\CreateUtensilHandler
 */
final class CreateUtensilHandlerTest extends KernelTestCase
{
    private EntityManagerInterface $em;
    private CreateUtensilHandler $handler;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->em = self::getContainer()->get(EntityManagerInterface::class);
        $this->handler = self::getContainer()->get(CreateUtensilHandler::class);

        // Isolation for every test: start a DB transaction and roll it back in tearDown
        $this->em->beginTransaction();
    }

    protected function tearDown(): void
    {
        $this->em->rollback();
        $this->em->close();
        parent::tearDown();
    }

    public function testItCreatesAnUtensilAndReturnsItsId(): void
    {
        $command = new CreateUtensilCommand(
            name: 'Utensil',
        );

        $returnedId = ($this->handler)($command);

        /** @var ?Utensil $Utensil */
        $Utensil = $this->em->getRepository(Utensil::class)->find($returnedId);

        self::assertNotNull($Utensil, 'Utensil should have been persisted');
        self::assertSame('Utensil', $Utensil->getName());
    }
}
