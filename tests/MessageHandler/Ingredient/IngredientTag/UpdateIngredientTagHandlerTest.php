<?php

declare(strict_types=1);

namespace App\Tests\MessageHandler\Ingredient\IngredientTag;

use App\DataFixtures\Ingredient\IngredientTagFixture;
use App\Entity\Ingredient\IngredientTag;
use App\MessageHandler\Ingredient\IngredientTag\UpdateIngredientTag\UpdateIngredientTagCommand;
use App\MessageHandler\Ingredient\IngredientTag\UpdateIngredientTag\UpdateIngredientTagHandler;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @covers \App\MessageHandler\Ingredient\IngredientTag\UpdateIngredientTag\UpdateIngredientTagHandler
 */
final class UpdateIngredientTagHandlerTest extends KernelTestCase
{
    private EntityManagerInterface $em;
    private UpdateIngredientTagHandler $handler;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->em = self::getContainer()->get(EntityManagerInterface::class);
        $this->handler = self::getContainer()->get(UpdateIngredientTagHandler::class);

        // Isolation par transaction
        $this->em->beginTransaction();

        // Charge la fixture (une seule ligne !)
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

    public function testItUpdatesAnIngredientTag(): void
    {
        /** @var ?IngredientTag $tag */
        $tag = $this->em->getRepository(IngredientTag::class)
            ->findOneBy(['name' => IngredientTagFixture::ORIGINAL_NAME]);

        self::assertNotNull($tag, 'Le tag d\'ingredient de la fixture n’a pas été trouvée');

        $command = new UpdateIngredientTagCommand(
            id: $tag->getId(),
            name: 'UpdatedName'
        );

        ($this->handler)($command);

        /** @var IngredientTag $updated */
        $updated = $this->em->getRepository(IngredientTag::class)->find($tag->getId());

        self::assertSame('UpdatedName', $updated->getName());
    }
}
