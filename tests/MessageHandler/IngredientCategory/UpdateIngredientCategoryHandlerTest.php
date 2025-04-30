<?php
declare(strict_types=1);

namespace App\Tests\MessageHandler\IngredientCategory;

use App\DataFixtures\IngredientCategoryFixture;
use App\Entity\IngredientCategory;
use App\MessageHandler\IngredientCategory\UpdateIngredientCategory\UpdateIngredientCategoryCommand;
use App\MessageHandler\IngredientCategory\UpdateIngredientCategory\UpdateIngredientCategoryHandler;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @covers \App\MessageHandler\IngredientCategory\UpdateIngredientCategory\UpdateIngredientCategoryHandler
 */
final class UpdateIngredientCategoryHandlerTest extends KernelTestCase
{
    private EntityManagerInterface          $em;
    private UpdateIngredientCategoryHandler $handler;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->em      = self::getContainer()->get(EntityManagerInterface::class);
        $this->handler = self::getContainer()->get(UpdateIngredientCategoryHandler::class);

        // Isolation par transaction
        $this->em->beginTransaction();

        // Charge la fixture (une seule ligne !)
        $loader = new Loader();
        $loader->addFixture(new IngredientCategoryFixture());

        (new ORMExecutor($this->em, new ORMPurger()))
            ->execute($loader->getFixtures(), append: true);
    }

    protected function tearDown(): void
    {
        $this->em->rollback();
        $this->em->close();
        parent::tearDown();
    }

    public function testItUpdatesAnIngredientCategory(): void
    {
        /** @var IngredientCategory $category */
        $category = $this->em->getRepository(IngredientCategory::class)
            ->findOneBy(['name' => IngredientCategoryFixture::ORIGINAL_NAME]);

        self::assertNotNull($category, 'La catégorie de la fixture n’a pas été trouvée');

        $command = new UpdateIngredientCategoryCommand(
            id:   $category->getId(),
            name: 'UpdatedName'
        );

        ($this->handler)($command);

        /** @var IngredientCategory $updated */
        $updated = $this->em->getRepository(IngredientCategory::class)->find($category->getId());

        self::assertSame('UpdatedName', $updated->getName());
    }
}
