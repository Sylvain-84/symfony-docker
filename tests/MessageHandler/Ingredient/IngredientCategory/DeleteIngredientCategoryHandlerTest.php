<?php

declare(strict_types=1);

namespace App\Tests\MessageHandler\Ingredient\IngredientCategory;

use App\DataFixtures\Ingredient\IngredientCategoryFixture;
use App\Entity\Ingredient\IngredientCategory;
use App\MessageHandler\Ingredient\IngredientCategory\DeleteIngredientCategory\DeleteIngredientCategoryCommand;
use App\MessageHandler\Ingredient\IngredientCategory\DeleteIngredientCategory\DeleteIngredientCategoryHandler;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @covers \App\MessageHandler\Ingredient\IngredientCategory\DeleteIngredientCategory\DeleteIngredientCategoryHandler
 */
final class DeleteIngredientCategoryHandlerTest extends KernelTestCase
{
    private EntityManagerInterface $em;
    private DeleteIngredientCategoryHandler $handler;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->em = self::getContainer()->get(EntityManagerInterface::class);
        $this->handler = self::getContainer()->get(DeleteIngredientCategoryHandler::class);

        $this->em->beginTransaction();

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

    public function testItDeletesAnIngredientCategory(): void
    {
        /** @var IngredientCategory|null $ingredientCategory */
        $ingredientCategory = $this->em
            ->getRepository(IngredientCategory::class)
            ->findOneBy(['name' => IngredientCategoryFixture::ORIGINAL_NAME_UNUSED]);
        $ingredientCategoryId = $ingredientCategory->getId();

        self::assertNotNull($ingredientCategory, "L'ingrédient fixture n'existe pas");

        $command = new DeleteIngredientCategoryCommand($ingredientCategoryId);

        ($this->handler)($command);

        $deleted = $this->em->getRepository(IngredientCategory::class)->find($ingredientCategoryId);
        self::assertNull($deleted, 'L’ingrédient devrait être supprimé de la base');
    }

    public function testItThrowsWhenCategoryIsUsedByIngredient(): void
    {
        /** @var IngredientCategory|null $used */
        $used = $this->em->getRepository(IngredientCategory::class)
            ->findOneBy(['name' => IngredientCategoryFixture::ORIGINAL_NAME]);

        self::assertNotNull($used, 'Catégorie “USED” manquante');
        $this->assertGreaterThan(0, $used->getIngredients()->count());

        $command = new DeleteIngredientCategoryCommand($used->getId());

        $this->expectException(ForeignKeyConstraintViolationException::class);

        ($this->handler)($command);
    }
}
