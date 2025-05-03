<?php

declare(strict_types=1);

namespace App\Tests\MessageHandler\Recipe\RecipeCategory;

use App\DataFixtures\Recipe\RecipeCategoryFixture;
use App\Entity\Recipe\RecipeCategory;
use App\MessageHandler\Recipe\RecipeCategory\UpdateRecipeCategory\UpdateRecipeCategoryCommand;
use App\MessageHandler\Recipe\RecipeCategory\UpdateRecipeCategory\UpdateRecipeCategoryHandler;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @covers \App\MessageHandler\Recipe\RecipeCategory\UpdateRecipeCategory\UpdateRecipeCategoryHandler
 */
final class UpdateRecipeCategoryHandlerTest extends KernelTestCase
{
    private EntityManagerInterface $em;
    private UpdateRecipeCategoryHandler $handler;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->em = self::getContainer()->get(EntityManagerInterface::class);
        $this->handler = self::getContainer()->get(UpdateRecipeCategoryHandler::class);

        // Isolation par transaction
        $this->em->beginTransaction();

        // Charge la fixture (une seule ligne !)
        $loader = new Loader();
        $loader->addFixture(new RecipeCategoryFixture());

        (new ORMExecutor($this->em, new ORMPurger()))
            ->execute($loader->getFixtures(), append: true);
    }

    protected function tearDown(): void
    {
        $this->em->rollback();
        $this->em->close();
        parent::tearDown();
    }

    public function testItUpdatesAnRecipeCategory(): void
    {
        /** @var ?RecipeCategory $category */
        $category = $this->em->getRepository(RecipeCategory::class)
            ->findOneBy(['name' => RecipeCategoryFixture::ORIGINAL_NAME]);

        self::assertNotNull($category, 'La catégorie de la fixture n’a pas été trouvée');

        $command = new UpdateRecipeCategoryCommand(
            id: $category->getId(),
            name: 'UpdatedName'
        );

        ($this->handler)($command);

        /** @var RecipeCategory $updated */
        $updated = $this->em->getRepository(RecipeCategory::class)->find($category->getId());

        self::assertSame('UpdatedName', $updated->getName());
    }
}
