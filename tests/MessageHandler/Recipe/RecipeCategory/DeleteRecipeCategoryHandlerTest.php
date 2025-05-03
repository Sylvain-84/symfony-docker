<?php

declare(strict_types=1);

namespace App\Tests\MessageHandler\Recipe\RecipeCategory;

use App\Entity\Recipe\Recipe;
use App\Entity\Recipe\RecipeCategory;
use App\Enum\DifficultyEnum;
use App\MessageHandler\Recipe\RecipeCategory\DeleteRecipeCategory\DeleteRecipeCategoryCommand;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * @covers \App\MessageHandler\Recipe\RecipeCategory\DeleteRecipeCategory\DeleteRecipeCategoryHandler
 */
final class DeleteRecipeCategoryHandlerTest extends KernelTestCase
{
    private EntityManagerInterface $em;
    private MessageBusInterface $bus;

    protected function setUp(): void
    {
        self::bootKernel();
        $c = self::getContainer();
        $this->em = $c->get(EntityManagerInterface::class);
        $this->bus = $c->get(MessageBusInterface::class);
    }

    public function testItDeletesARecipeCategory(): void
    {
        // Arrange
        $category = new RecipeCategory('Drinks');
        $this->em->persist($category);
        $this->em->flush();

        $categoryId = $category->getId();

        // Act
        $this->bus->dispatch(new DeleteRecipeCategoryCommand($categoryId));

        // Assert
        $this->assertNull(
            $this->em->find(RecipeCategory::class, $categoryId),
            'Category should be removed from the database'
        );
    }

    public function testItThrowsWhenCategoryIsUsedByRecipe(): void
    {
        $category = new RecipeCategory('Lunch');
        $recipe = new Recipe('Banana dark chocolate', $category, DifficultyEnum::EASY);

        $this->em->persist($category);
        $this->em->persist($recipe);
        $this->em->flush();

        try {
            $this->bus->dispatch(new DeleteRecipeCategoryCommand($category->getId()));
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
