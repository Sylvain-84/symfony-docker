<?php

declare(strict_types=1);

namespace App\Tests\MessageHandler\Recipe\Recipe;

use App\DataFixtures\RecipeFixture;
use App\Entity\Recipe\Recipe;
use App\MessageHandler\Recipe\Recipe\DeleteRecipe\DeleteRecipeCommand;
use App\MessageHandler\Recipe\Recipe\DeleteRecipe\DeleteRecipeHandler;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @covers \App\MessageHandler\Recipe\Recipe\DeleteRecipe\DeleteRecipeHandler
 */
final class DeleteRecipeHandlerTest extends KernelTestCase
{
    private EntityManagerInterface $em;
    private DeleteRecipeHandler $handler;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->em = self::getContainer()->get(EntityManagerInterface::class);
        $this->handler = self::getContainer()->get(DeleteRecipeHandler::class);

        // Isolation transactionnelle
        $this->em->beginTransaction();

        // On charge la catégorie + l'ingrédient basique
        $loader = new Loader();
        $loader->addFixture(new RecipeFixture());

        (new ORMExecutor($this->em, new ORMPurger()))
            ->execute($loader->getFixtures(), append: true);
    }

    protected function tearDown(): void
    {
        $this->em->rollback();
        $this->em->close();
        parent::tearDown();
    }

    public function testItDeletesARecipe(): void
    {
        /** @var Recipe|null $recipe */
        $recipe = $this->em
            ->getRepository(Recipe::class)
            ->findOneBy(['name' => RecipeFixture::ORIGINAL_NAME]);
        $recipeId = $recipe->getId();

        self::assertNotNull($recipe, "La recette fixture n'existe pas");

        $command = new DeleteRecipeCommand($recipeId);

        ($this->handler)($command);

        $deleted = $this->em->getRepository(Recipe::class)->find($recipeId);
        self::assertNull($deleted, 'La recette devrait être supprimé de la base');
    }
}
