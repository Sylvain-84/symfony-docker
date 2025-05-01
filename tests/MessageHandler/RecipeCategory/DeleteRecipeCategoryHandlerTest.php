<?php

declare(strict_types=1);

namespace App\Tests\MessageHandler\RecipeCategory;

use App\DataFixtures\RecipeCategoryFixture;
use App\Entity\RecipeCategory;
use App\MessageHandler\RecipeCategory\DeleteRecipeCategory\DeleteRecipeCategoryCommand;
use App\MessageHandler\RecipeCategory\DeleteRecipeCategory\DeleteRecipeCategoryHandler;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @covers \App\MessageHandler\RecipeCategory\DeleteRecipeCategory\DeleteRecipeCategoryHandler
 */
final class DeleteRecipeCategoryHandlerTest extends KernelTestCase
{
    private EntityManagerInterface $em;
    private DeleteRecipeCategoryHandler $handler;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->em = self::getContainer()->get(EntityManagerInterface::class);
        $this->handler = self::getContainer()->get(DeleteRecipeCategoryHandler::class);

        $this->em->beginTransaction();

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

    public function testItDeletesAnRecipeCategory(): void
    {
        /** @var RecipeCategory|null $RecipeCategory */
        $RecipeCategory = $this->em
            ->getRepository(RecipeCategory::class)
            ->findOneBy(['name' => RecipeCategoryFixture::ORIGINAL_NAME_UNUSED]);
        $RecipeCategoryId = $RecipeCategory->getId();

        self::assertNotNull($RecipeCategory, "L'ingrédient fixture n'existe pas");

        $command = new DeleteRecipeCategoryCommand($RecipeCategoryId);

        ($this->handler)($command);

        $deleted = $this->em->getRepository(RecipeCategory::class)->find($RecipeCategoryId);
        self::assertNull($deleted, 'L’ingrédient devrait être supprimé de la base');
    }

    public function testItThrowsWhenCategoryIsUsedByRecipe(): void
    {
        /** @var RecipeCategory|null $used */
        $used = $this->em->getRepository(RecipeCategory::class)
            ->findOneBy(['name' => RecipeCategoryFixture::ORIGINAL_NAME]);

        self::assertNotNull($used, 'Catégorie “USED” manquante');
        $this->assertGreaterThan(0, $used->getRecipes()->count());

        $command = new DeleteRecipeCategoryCommand($used->getId());

        $this->expectException(ForeignKeyConstraintViolationException::class);

        ($this->handler)($command);
    }
}
