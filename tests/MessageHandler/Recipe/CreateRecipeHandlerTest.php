<?php

declare(strict_types=1);

namespace App\Tests\MessageHandler\Recipe;

use App\DataFixtures\RecipeCategoryFixture;
use App\Entity\Recipe;
use App\Entity\RecipeCategory;
use App\MessageHandler\Recipe\CreateRecipe\CreateRecipeCommand;
use App\MessageHandler\Recipe\CreateRecipe\CreateRecipeHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @covers \App\MessageHandler\Recipe\CreateRecipe\CreateRecipeHandler
 */
final class CreateRecipeHandlerTest extends KernelTestCase
{
    private EntityManagerInterface $em;
    private CreateRecipeHandler $handler;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->em = self::getContainer()->get(EntityManagerInterface::class);
        $this->handler = self::getContainer()->get(CreateRecipeHandler::class);

        // Isolation for every test: start a DB transaction and roll it back in tearDown
        $this->em->beginTransaction();
    }

    protected function tearDown(): void
    {
        $this->em->rollback();
        $this->em->close();
        parent::tearDown();
    }

    public function testItCreatesARecipeAndReturnsItsId(): void
    {
        /** @var ?RecipeCategory $category */
        $category = $this->em->getRepository(RecipeCategory::class)
            ->findOneBy(['name' => RecipeCategoryFixture::ORIGINAL_NAME]);

        self::assertNotNull($category, 'La catégorie de la fixture n’a pas été trouvée');

        $command = new CreateRecipeCommand(
            name: 'Banana dark chocolate',
            category: $category->getId(),
            description: 'It is a recipe with banana dark chocolate',
        );

        $returnedId = ($this->handler)($command);

        /** @var ?Recipe $recipe */
        $recipe = $this->em->getRepository(Recipe::class)->find($returnedId);

        self::assertNotNull($recipe, 'Recipe should have been persisted');
        self::assertSame('Banana dark chocolate', $recipe->getName());
        self::assertSame('It is a recipe with banana dark chocolate', $recipe->getDescription());
        self::assertSame($category->getId(), $recipe->getCategory()->getId());
    }

    public function testItThrowsWhenCategoryDoesNotExist(): void
    {
        $nonExistingCategoryId = 999_999;

        $command = new CreateRecipeCommand(
            name: 'Mixed eggs',
            category: $nonExistingCategoryId
        );

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Recipe category #' . $nonExistingCategoryId . ' not found.');

        ($this->handler)($command);
    }
}
