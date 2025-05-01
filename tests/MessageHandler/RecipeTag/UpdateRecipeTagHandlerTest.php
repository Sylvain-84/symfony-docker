<?php

declare(strict_types=1);

namespace App\Tests\MessageHandler\RecipeTag;

use App\DataFixtures\RecipeTagFixture;
use App\Entity\RecipeTag;
use App\MessageHandler\RecipeTag\UpdateRecipeTag\UpdateRecipeTagCommand;
use App\MessageHandler\RecipeTag\UpdateRecipeTag\UpdateRecipeTagHandler;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @covers \App\MessageHandler\RecipeTag\UpdateRecipeTag\UpdateRecipeTagHandler
 */
final class UpdateRecipeTagHandlerTest extends KernelTestCase
{
    private EntityManagerInterface $em;
    private UpdateRecipeTagHandler $handler;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->em = self::getContainer()->get(EntityManagerInterface::class);
        $this->handler = self::getContainer()->get(UpdateRecipeTagHandler::class);

        // Isolation par transaction
        $this->em->beginTransaction();

        // Charge la fixture (une seule ligne !)
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

    public function testItUpdatesAnRecipeTag(): void
    {
        /** @var ?RecipeTag $tag */
        $tag = $this->em->getRepository(RecipeTag::class)
            ->findOneBy(['name' => RecipeTagFixture::ORIGINAL_NAME]);

        self::assertNotNull($tag, 'Le tag de recette de la fixture n’a pas été trouvée');

        $command = new UpdateRecipeTagCommand(
            id: $tag->getId(),
            name: 'UpdatedName'
        );

        ($this->handler)($command);

        /** @var RecipeTag $updated */
        $updated = $this->em->getRepository(RecipeTag::class)->find($tag->getId());

        self::assertSame('UpdatedName', $updated->getName());
    }
}
