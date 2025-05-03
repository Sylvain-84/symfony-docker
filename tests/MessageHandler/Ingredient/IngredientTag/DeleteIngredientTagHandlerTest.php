<?php

declare(strict_types=1);

namespace App\Tests\MessageHandler\Ingredient\IngredientTag;

use App\DataFixtures\Ingredient\IngredientTagFixture;
use App\Entity\Ingredient\IngredientTag;
use App\MessageHandler\Ingredient\IngredientTag\DeleteIngredientTag\DeleteIngredientTagCommand;
use App\MessageHandler\Ingredient\IngredientTag\DeleteIngredientTag\DeleteIngredientTagHandler;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @covers \App\MessageHandler\Ingredient\IngredientTag\DeleteIngredientTag\DeleteIngredientTagHandler
 */
final class DeleteIngredientTagHandlerTest extends KernelTestCase
{
    private EntityManagerInterface $em;
    private DeleteIngredientTagHandler $handler;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->em = self::getContainer()->get(EntityManagerInterface::class);
        $this->handler = self::getContainer()->get(DeleteIngredientTagHandler::class);

        $this->em->beginTransaction();

        $loader = new Loader();
        $loader->addFixture(new IngredientTagFixture());

        (new ORMExecutor($this->em, new ORMPurger()))
            ->execute($loader->getFixtures(), append: true);
    }

    protected function tearDown(): void
    {
        $this->em->rollback();
        $this->em->close();
        parent::tearDown();
    }

    public function testItDeletesAnIngredientTag(): void
    {
        /** @var IngredientTag|null $IngredientTag */
        $IngredientTag = $this->em
            ->getRepository(IngredientTag::class)
            ->findOneBy(['name' => IngredientTagFixture::ORIGINAL_NAME_UNUSED]);
        $IngredientTagId = $IngredientTag->getId();

        self::assertNotNull($IngredientTag, "Le tag d'ingredient fixture n'existe pas");

        $command = new DeleteIngredientTagCommand($IngredientTagId);

        ($this->handler)($command);

        $deleted = $this->em->getRepository(IngredientTag::class)->find($IngredientTagId);
        self::assertNull($deleted, 'Le tag de d\'ingredient devrait être supprimé de la base');
    }
}
