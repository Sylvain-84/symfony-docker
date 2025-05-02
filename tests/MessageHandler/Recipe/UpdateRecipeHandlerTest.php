<?php

declare(strict_types=1);

namespace App\Tests\MessageHandler\Recipe;

use App\DataFixtures\RecipeCategoryFixture;
use App\DataFixtures\RecipeFixture;
use App\DataFixtures\RecipeTagFixture;
use App\Entity\Recipe;
use App\Entity\RecipeCategory;
use App\Entity\RecipeTag;
use App\Enum\DifficultyEnum;
use App\MessageHandler\Recipe\UpdateRecipe\UpdateRecipeCommand;
use App\MessageHandler\Recipe\UpdateRecipe\UpdateRecipeHandler;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @covers \App\MessageHandler\Recipe\UpdateRecipe\UpdateRecipeHandler
 */
final class UpdateRecipeHandlerTest extends KernelTestCase
{
    private EntityManagerInterface $em;
    private UpdateRecipeHandler $handler;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->em = self::getContainer()->get(EntityManagerInterface::class);
        $this->handler = self::getContainer()->get(UpdateRecipeHandler::class);

        // Isolation par transaction
        $this->em->beginTransaction();

        // Charge la fixture catégorie
        $loader = new Loader();
        $loader->addFixture(new RecipeCategoryFixture());
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

    public function testItUpdatesARecipe(): void
    {
        /** @var RecipeCategory|null $category */
        $category = $this->em->getRepository(RecipeCategory::class)
            ->findOneBy(['name' => RecipeCategoryFixture::ORIGINAL_NAME]);

        self::assertNotNull($category, 'La catégorie fixture devrait exister');

        /** @var Recipe|null $recipe */
        $recipe = $this->em->getRepository(Recipe::class)
            ->findOneBy(['name' => RecipeFixture::ORIGINAL_NAME]);
        self::assertNotNull($recipe, 'La recette de la fixture devrait exister');

        $tag = $this->em->getRepository(RecipeTag::class)
            ->findOneBy(['name' => RecipeTagFixture::ORIGINAL_NAME]);
        $new_tag = $this->em->getRepository(RecipeTag::class)
            ->findOneBy(['name' => RecipeTagFixture::ORIGINAL_NAME_3]);

        $updateCommand = new UpdateRecipeCommand(
            id: $recipe->getId(),
            category: $category->getId(),
            name: 'Green Apple',
            difficulty: DifficultyEnum::HARD,
            description: 'It is a recipe with green apple',
            tags: [$tag->getId(), $new_tag->getId()],
            servings: 8
        );

        ($this->handler)($updateCommand);

        /** @var Recipe $updated */
        $updated = $this->em->getRepository(Recipe::class)->find($recipe->getId());

        self::assertSame('Green Apple', $updated->getName());
        self::assertSame('It is a recipe with green apple', $updated->getDescription());
        self::assertSame($category->getId(), $updated->getCategory()->getId());
        self::assertSame($tag->getName(), $recipe->getTags()->first()->getName());
        self::assertSame($new_tag->getName(), $recipe->getTags()->get(1)->getName());
        self::assertSame(DifficultyEnum::HARD, $updated->getDifficulty());
        self::assertSame(8, $updated->getServings());
    }

    public function testItThrowsWhenRecipeDoesNotExist(): void
    {
        $nonExistingId = 999_999;

        $command = new UpdateRecipeCommand(
            id: $nonExistingId,
            category: 1,
            name: 'Does not matter',
            difficulty: DifficultyEnum::HARD,
            servings: 1
        );

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Recipe #' . $nonExistingId . ' not found.');

        ($this->handler)($command);
    }
}
