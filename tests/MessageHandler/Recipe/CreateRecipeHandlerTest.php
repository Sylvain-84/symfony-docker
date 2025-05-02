<?php

declare(strict_types=1);

namespace App\Tests\MessageHandler\Recipe;

use App\DataFixtures\RecipeCategoryFixture;
use App\DataFixtures\RecipeTagFixture;
use App\Entity\Recipe;
use App\Entity\RecipeCategory;
use App\Entity\RecipeTag;
use App\Enum\DifficultyEnum;
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

        $tag = $this->em->getRepository(RecipeTag::class)
            ->findOneBy(['name' => RecipeTagFixture::ORIGINAL_NAME]);
        $tag2 = $this->em->getRepository(RecipeTag::class)
            ->findOneBy(['name' => RecipeTagFixture::ORIGINAL_NAME_2]);

        $command = new CreateRecipeCommand(
            name: 'Banana dark chocolate',
            category: $category->getId(),
            difficulty: DifficultyEnum::EASY,
            servings: 3,
            description: 'It is a recipe with banana dark chocolate',
            tags: [$tag->getId(), $tag2->getId()]
        );

        $returnedId = ($this->handler)($command);

        /** @var ?Recipe $recipe */
        $recipe = $this->em->getRepository(Recipe::class)->find($returnedId);

        self::assertNotNull($recipe, 'Recipe should have been persisted');
        self::assertSame('Banana dark chocolate', $recipe->getName());
        self::assertSame('It is a recipe with banana dark chocolate', $recipe->getDescription());
        self::assertSame($category->getId(), $recipe->getCategory()->getId());
        self::assertCount(2, $recipe->getTags(), 'Recipe should have 2 tags');
        self::assertSame($tag->getName(), $recipe->getTags()->first()->getName());
        self::assertSame($tag2->getName(), $recipe->getTags()->get(1)->getName());
        self::assertSame(DifficultyEnum::EASY, $recipe->getDifficulty());
        self::assertSame(3, $recipe->getServings());
    }

    public function testItThrowsWhenCategoryDoesNotExist(): void
    {
        $nonExistingCategoryId = 999_999;

        $command = new CreateRecipeCommand(
            name: 'Mixed eggs',
            category: $nonExistingCategoryId,
            difficulty: DifficultyEnum::EASY,
            servings: 1
        );

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Recipe category #' . $nonExistingCategoryId . ' not found.');

        ($this->handler)($command);
    }
}
