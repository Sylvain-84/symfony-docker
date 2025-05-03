<?php

declare(strict_types=1);

namespace App\Tests\MessageHandler\Ingredient\IngredientCategory;

use App\DataFixtures\Ingredient\IngredientCategoryFixture;
use App\Entity\Ingredient\Ingredient;
use App\Entity\Ingredient\IngredientCategory;
use App\MessageHandler\Ingredient\IngredientCategory\DeleteIngredientCategory\DeleteIngredientCategoryCommand;
use App\MessageHandler\Ingredient\IngredientCategory\DeleteIngredientCategory\DeleteIngredientCategoryHandler;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * @covers \App\MessageHandler\Ingredient\IngredientCategory\DeleteIngredientCategory\DeleteIngredientCategoryHandler
 */
final class DeleteIngredientCategoryHandlerTest extends KernelTestCase
{
    private EntityManagerInterface $em;
    private DeleteIngredientCategoryHandler $handler;
    private MessageBusInterface $bus;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->em = self::getContainer()->get(EntityManagerInterface::class);
        $this->handler = self::getContainer()->get(DeleteIngredientCategoryHandler::class);
        $this->bus = self::getContainer()->get(MessageBusInterface::class);

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
        $category = new IngredientCategory('Lunch');
        $ingredient = new Ingredient('Banana dark chocolate', $category);

        $this->em->persist($category);
        $this->em->persist($ingredient);
        $this->em->flush();

        try {
            $this->bus->dispatch(new DeleteIngredientCategoryCommand($category->getId()));
            self::fail('Foreign-key violation expected');
        } catch (HandlerFailedException $e) {
            $this->assertInstanceOf(
                ForeignKeyConstraintViolationException::class,
                array_values($e->getWrappedExceptions())[0],
                'Inner exception should be DBAL foreign-key violation'
            );
        }
    }
}
