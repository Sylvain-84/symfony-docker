<?php

declare(strict_types=1);

namespace App\Tests\MessageHandler\Recipe\Utensil;

use App\DataFixtures\Recipe\UtensilFixture;
use App\Entity\Recipe\Utensil;
use App\MessageHandler\Recipe\Utensil\UpdateUtensil\UpdateUtensilCommand;
use App\MessageHandler\Recipe\Utensil\UpdateUtensil\UpdateUtensilHandler;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @covers \App\MessageHandler\Recipe\Utensil\UpdateUtensil\UpdateUtensilHandler
 */
final class UpdateUtensilHandlerTest extends KernelTestCase
{
    private EntityManagerInterface $em;
    private UpdateUtensilHandler $handler;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->em = self::getContainer()->get(EntityManagerInterface::class);
        $this->handler = self::getContainer()->get(UpdateUtensilHandler::class);

        // Isolation par transaction
        $this->em->beginTransaction();

        // Charge la fixture (une seule ligne !)
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

    public function testItUpdatesAnUtensil(): void
    {
        /** @var ?Utensil $tag */
        $tag = $this->em->getRepository(Utensil::class)
            ->findOneBy(['name' => UtensilFixture::ORIGINAL_NAME]);

        self::assertNotNull($tag, 'L\'ustensil de la fixture n’a pas été trouvé');

        $command = new UpdateUtensilCommand(
            id: $tag->getId(),
            name: 'UpdatedName'
        );

        ($this->handler)($command);

        /** @var Utensil $updated */
        $updated = $this->em->getRepository(Utensil::class)->find($tag->getId());

        self::assertSame('UpdatedName', $updated->getName());
    }
}
