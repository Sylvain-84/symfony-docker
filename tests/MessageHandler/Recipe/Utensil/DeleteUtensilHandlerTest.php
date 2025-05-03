<?php

declare(strict_types=1);

namespace App\Tests\MessageHandler\Recipe\Utensil;

use App\DataFixtures\Recipe\UtensilFixture;
use App\Entity\Recipe\Utensil;
use App\MessageHandler\Recipe\Utensil\DeleteUtensil\DeleteUtensilCommand;
use App\MessageHandler\Recipe\Utensil\DeleteUtensil\DeleteUtensilHandler;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @covers \App\MessageHandler\Recipe\Utensil\DeleteUtensil\DeleteUtensilHandler
 */
final class DeleteUtensilHandlerTest extends KernelTestCase
{
    private EntityManagerInterface $em;
    private DeleteUtensilHandler $handler;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->em = self::getContainer()->get(EntityManagerInterface::class);
        $this->handler = self::getContainer()->get(DeleteUtensilHandler::class);

        $this->em->beginTransaction();

        $loader = new Loader();
        $loader->addFixture(new UtensilFixture());

        (new ORMExecutor($this->em, new ORMPurger()))
            ->execute($loader->getFixtures(), append: true);
    }

    protected function tearDown(): void
    {
        $this->em->rollback();
        $this->em->close();
        parent::tearDown();
    }

    public function testItDeletesAnUtensil(): void
    {
        /** @var Utensil|null $Utensil */
        $Utensil = $this->em
            ->getRepository(Utensil::class)
            ->findOneBy(['name' => UtensilFixture::ORIGINAL_NAME_UNUSED]);
        $UtensilId = $Utensil->getId();

        self::assertNotNull($Utensil, "L'ustensil fixture n'existe pas");

        $command = new DeleteUtensilCommand($UtensilId);

        ($this->handler)($command);

        $deleted = $this->em->getRepository(Utensil::class)->find($UtensilId);
        self::assertNull($deleted, 'L\'ustensil devrait être supprimé de la base');
    }
}
