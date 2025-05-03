<?php

declare(strict_types=1);

namespace App\Tests\MessageHandler\Recipe\Recipe;

use App\DataFixtures\Recipe\RecipeFixture;
use App\Entity\Recipe\Recipe;
use App\MessageHandler\Recipe\Recipe\AddCommentToRecipe\AddCommentToRecipeCommand;
use App\MessageHandler\Recipe\Recipe\AddCommentToRecipe\AddCommentToRecipeHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @covers \App\MessageHandler\Recipe\Recipe\AddCommentToRecipe\AddCommentToRecipeHandler
 */
final class AddCommentToRecipeHandlerTest extends KernelTestCase
{
    private EntityManagerInterface $em;
    private AddCommentToRecipeHandler $handler;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->em = self::getContainer()->get(EntityManagerInterface::class);
        $this->handler = self::getContainer()->get(AddCommentToRecipeHandler::class);

        // Isolation for every test: start a DB transaction and roll it back in tearDown
        $this->em->beginTransaction();
    }

    protected function tearDown(): void
    {
        $this->em->rollback();
        $this->em->close();
        parent::tearDown();
    }

    public function testItCreatesARecipe(): void
    {
        /** @var ?Recipe $recipe */
        $recipe = $this->em->getRepository(Recipe::class)
            ->findOneBy(['name' => RecipeFixture::ORIGINAL_NAME]);

        self::assertNotNull($recipe, 'La recette de la fixture n’a pas été trouvée');

        $command = new AddCommentToRecipeCommand(
            recipeId: $recipe->getId(),
            comment: 'Cooked it with a pinch of salt',
        );

        ($this->handler)($command);

        /** @var ?Recipe $recipe */
        $recipe = $this->em->getRepository(Recipe::class)->find($recipe->getId());

        self::assertNotNull($recipe, 'Recipe should have been persisted');
        self::assertCount(1, $recipe->getComments(), 'Recipe should have one comment');
        self::assertSame('Cooked it with a pinch of salt', $recipe->getComments()->last()->getComment());
    }

    public function testItThrowsWhenRecipeDoesNotExist(): void
    {
        $nonExistingCategoryId = 999_999;

        $command = new AddCommentToRecipeCommand(
            recipeId: $nonExistingCategoryId,
            comment: 'Cooked it with a pinch of salt',
        );

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Recipe #' . $nonExistingCategoryId . ' not found.');

        ($this->handler)($command);
    }
}
