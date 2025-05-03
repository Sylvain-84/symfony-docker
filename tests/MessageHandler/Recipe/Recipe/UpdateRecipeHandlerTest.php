<?php

declare(strict_types=1);

namespace App\Tests\MessageHandler\Recipe\Recipe;

use App\DataFixtures\RecipeCategoryFixture;
use App\DataFixtures\RecipeFixture;
use App\DataFixtures\RecipeTagFixture;
use App\DataFixtures\UtensilFixture;
use App\Entity\Recipe\Recipe;
use App\Entity\Recipe\RecipeCategory;
use App\Entity\Recipe\RecipeTag;
use App\Entity\Recipe\Utensil;
use App\Enum\DifficultyEnum;
use App\MessageHandler\Recipe\Recipe\InstructionInput;
use App\MessageHandler\Recipe\Recipe\UpdateRecipe\UpdateRecipeCommand;
use App\MessageHandler\Recipe\Recipe\UpdateRecipe\UpdateRecipeHandler;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @covers \App\MessageHandler\Recipe\Recipe\UpdateRecipe\UpdateRecipeHandler
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

        $utensil = $this->em->getRepository(Utensil::class)
            ->findOneBy(['name' => UtensilFixture::ORIGINAL_NAME]);
        $new_utensil = $this->em->getRepository(Utensil::class)
            ->findOneBy(['name' => UtensilFixture::ORIGINAL_NAME_3]);

        $instructions = [
            new InstructionInput('Préparer', 'Coupez les oranges en cubes', 1),
            new InstructionInput('Servir', 'Dressez dans les bols', 2),
        ];
        $updateCommand = new UpdateRecipeCommand(
            id: $recipe->getId(),
            category: $category->getId(),
            name: 'Green Apple Pie',
            difficulty: DifficultyEnum::HARD,
            servings: 8,
            preparationTime: 12,
            cookingTime: 30,
            description: 'It is a recipe with green apple',
            tags: [$tag->getId(), $new_tag->getId()],
            utensils: [$utensil->getId(), $new_utensil->getId()],
            note: 3,
            instructions: $instructions
        );

        ($this->handler)($updateCommand);

        /** @var Recipe $updated */
        $updated = $this->em->getRepository(Recipe::class)->find($recipe->getId());

        self::assertSame('Green Apple Pie', $updated->getName());
        self::assertSame('It is a recipe with green apple', $updated->getDescription());
        self::assertSame($category->getId(), $updated->getCategory()->getId());
        self::assertSame($tag->getId(), $recipe->getTags()->first()->getId());
        self::assertSame($new_tag->getId(), $recipe->getTags()->get(1)->getId());
        self::assertSame(DifficultyEnum::HARD, $updated->getDifficulty());
        self::assertSame(8, $updated->getServings());
        self::assertSame(12, $updated->getPreparationTime());
        self::assertSame(30, $updated->getCookingTime());
        self::assertSame($utensil->getId(), $updated->getUtensils()->first()->getId());
        self::assertSame($new_utensil->getId(), $updated->getUtensils()->get(1)->getId());
        self::assertSame(3, $updated->getNote());
        self::assertCount(2, $updated->getInstructions(), 'La recette devrait avoir 2 instructions');
        self::assertSame('Préparer', $updated->getInstructions()->first()->getName());
        self::assertSame(2, $updated->getInstructions()->last()->getPosition());
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
