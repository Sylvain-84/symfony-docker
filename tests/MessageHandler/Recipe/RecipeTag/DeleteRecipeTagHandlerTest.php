<?php

declare(strict_types=1);

namespace App\Tests\MessageHandler\Recipe\RecipeTag;

use App\DataFixtures\Recipe\RecipeTagFixture;
use App\Entity\Recipe\RecipeTag;
use App\MessageHandler\Recipe\RecipeTag\DeleteRecipeTag\DeleteRecipeTagCommand;
use App\MessageHandler\Recipe\RecipeTag\DeleteRecipeTag\DeleteRecipeTagHandler;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @covers \App\MessageHandler\Recipe\RecipeTag\DeleteRecipeTag\DeleteRecipeTagHandler
 */
final class DeleteRecipeTagHandlerTest extends KernelTestCase
{
    private EntityManagerInterface $em;
    private DeleteRecipeTagHandler $handler;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->em = self::getContainer()->get(EntityManagerInterface::class);
        $this->handler = self::getContainer()->get(DeleteRecipeTagHandler::class);

        $this->em->beginTransaction();

        $loader = new Loader();
        $loader->addFixture(new RecipeTagFixture());

        (new ORMExecutor($this->em, new ORMPurger()))
            ->execute($loader->getFixtures(), append: true);
    }

    protected function tearDown(): void
    {
        $this->em->rollback();
        $this->em->close();
        parent::tearDown();
    }

    public function testItDeletesAnRecipeTag(): void
    {
        /** @var RecipeTag|null $RecipeTag */
        $RecipeTag = $this->em
            ->getRepository(RecipeTag::class)
            ->findOneBy(['name' => RecipeTagFixture::ORIGINAL_NAME_UNUSED]);
        $RecipeTagId = $RecipeTag->getId();

        self::assertNotNull($RecipeTag, "Le tag de recette fixture n'existe pas");

        $command = new DeleteRecipeTagCommand($RecipeTagId);

        ($this->handler)($command);

        $deleted = $this->em->getRepository(RecipeTag::class)->find($RecipeTagId);
        self::assertNull($deleted, 'Le tag de recette devrait être supprimé de la base');
    }
}
