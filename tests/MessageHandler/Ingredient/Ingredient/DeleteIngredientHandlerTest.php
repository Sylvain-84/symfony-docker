<?php

declare(strict_types=1);

namespace App\Tests\MessageHandler\Ingredient\Ingredient;

use App\DataFixtures\Ingredient\IngredientFixture;
use App\Entity\Ingredient\Ingredient;
use App\MessageHandler\Ingredient\Ingredient\DeleteIngredient\DeleteIngredientCommand;
use App\MessageHandler\Ingredient\Ingredient\DeleteIngredient\DeleteIngredientHandler;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @covers \App\MessageHandler\Ingredient\Ingredient\DeleteIngredient\DeleteIngredientHandler
 */
final class DeleteIngredientHandlerTest extends KernelTestCase
{
    private EntityManagerInterface $em;
    private DeleteIngredientHandler $handler;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->em = self::getContainer()->get(EntityManagerInterface::class);
        $this->handler = self::getContainer()->get(DeleteIngredientHandler::class);

        // Isolation transactionnelle
        $this->em->beginTransaction();

        // On charge la catégorie + l'ingrédient basique
        $loader = new Loader();
        $loader->addFixture(new IngredientFixture());

        (new ORMExecutor($this->em, new ORMPurger()))
            ->execute($loader->getFixtures(), append: true);
    }

    protected function tearDown(): void
    {
        $this->em->rollback();
        $this->em->close();
        parent::tearDown();
    }

    public function testItDeletesAnIngredient(): void
    {
        /** @var Ingredient|null $ingredient */
        $ingredient = $this->em
            ->getRepository(Ingredient::class)
            ->findOneBy(['name' => IngredientFixture::ORIGINAL_NAME_UNUSED]);
        $ingredientId = $ingredient->getId();

        self::assertNotNull($ingredient, "L'ingrédient fixture n'existe pas");

        $command = new DeleteIngredientCommand($ingredientId);

        ($this->handler)($command);

        $deleted = $this->em->getRepository(Ingredient::class)->find($ingredientId);
        self::assertNull($deleted, 'L’ingrédient devrait être supprimé de la base');
    }
}
