<?php

declare(strict_types=1);

namespace App\Tests\MessageHandler\Recipe\Recipe;

use App\DataFixtures\Ingredient\IngredientFixture;
use App\DataFixtures\Recipe\RecipeCategoryFixture;
use App\DataFixtures\Recipe\RecipeFixture;
use App\DataFixtures\Recipe\RecipeTagFixture;
use App\DataFixtures\Recipe\UtensilFixture;
use App\Entity\Ingredient\Ingredient;
use App\Entity\Recipe\Recipe;
use App\Entity\Recipe\RecipeCategory;
use App\Entity\Recipe\RecipeIngredient;
use App\Entity\Recipe\RecipeTag;
use App\Entity\Recipe\Utensil;
use App\Enum\DifficultyEnum;
use App\Enum\UnityEnum;
use App\MessageHandler\Recipe\Recipe\InstructionInput;
use App\MessageHandler\Recipe\Recipe\RecipeIngredientInput;
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

        $this->em->beginTransaction();   // isolation BDD

        // charge toutes les fixtures utiles
        $loader = new Loader();
        $loader->addFixture(new RecipeCategoryFixture());
        $loader->addFixture(new RecipeFixture());
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

    // ───────────────────────────── TEST PRINCIPAL ─────────────────────────────
    public function testItUpdatesARecipe(): void
    {
        $category = $this->fetchCategory(RecipeCategoryFixture::ORIGINAL_NAME);
        $recipe = $this->fetchRecipe(RecipeFixture::ORIGINAL_NAME);

        // --- inputs ----------------------------------------------------------
        $tagIds = $this->fetchTagIds([RecipeTagFixture::ORIGINAL_NAME, RecipeTagFixture::ORIGINAL_NAME_3]);
        $utensilIds = $this->fetchUtensilIds([UtensilFixture::ORIGINAL_NAME, UtensilFixture::ORIGINAL_NAME_3]);
        $instructions = [
            new InstructionInput('Préparer', 'Coupez les oranges en cubes', 1),
            new InstructionInput('Servir', 'Dressez dans les bols', 2),
        ];
        $ingredients = $this->makeIngredientInputs();
        // ---------------------------------------------------------------------

        $cmd = new UpdateRecipeCommand(
            id: $recipe->getId(),
            category: $category->getId(),
            name: 'Green Apple Pie',
            difficulty: DifficultyEnum::HARD,
            servings: 8,
            preparationTime: 12,
            cookingTime: 30,
            description: 'It is a recipe with green apple',
            tags: $tagIds,
            utensils: $utensilIds,
            note: 3,
            instructions: $instructions,
            ingredients: $ingredients,
        );

        ($this->handler)($cmd);

        /** @var Recipe $updated */
        $updated = $this->em->getRepository(Recipe::class)->find($recipe->getId());

        // --- assertions simples ---------------------------------------------
        self::assertSame('Green Apple Pie', $updated->getName());
        self::assertSame('It is a recipe with green apple', $updated->getDescription());
        self::assertSame(DifficultyEnum::HARD, $updated->getDifficulty());
        self::assertSame(8, $updated->getServings());
        self::assertSame(12, $updated->getPreparationTime());
        self::assertSame(30, $updated->getCookingTime());
        self::assertSame(3, $updated->getNote());
        self::assertSame($category->getId(), $updated->getCategory()->getId());

        // Tags & utensils : on compare les ID sans se soucier de l’ordre
        self::assertEqualsCanonicalizing(
            $tagIds,
            $updated->getTags()->map(fn (RecipeTag $tag) => $tag->getId())->toArray()
        );
        self::assertEqualsCanonicalizing(
            $utensilIds,
            $updated->getUtensils()->map(fn (Utensil $utensil) => $utensil->getId())->toArray()
        );

        // Instructions
        self::assertCount(2, $updated->getInstructions());
        self::assertSame('Préparer', $updated->getInstructions()->first()->getName());
        self::assertSame(2, $updated->getInstructions()->last()->getPosition());

        // Ingredients
        self::assertCount(2, $updated->getIngredients());
        /** @var RecipeIngredient $firstIng */
        $firstIng = $updated->getIngredients()->first();
        self::assertSame(2.0, $firstIng->getQuantity());
        self::assertSame(UnityEnum::GRAMS, $firstIng->getUnit());
    }

    // ───────────────────────────── Helpers privés ────────────────────────────
    private function fetchCategory(string $name): RecipeCategory
    {
        return $this->em->getRepository(RecipeCategory::class)->findOneBy(['name' => $name])
            ?? throw new \LogicException("Category $name not found");
    }

    private function fetchRecipe(string $name): Recipe
    {
        return $this->em->getRepository(Recipe::class)->findOneBy(['name' => $name])
            ?? throw new \LogicException("Recipe $name not found");
    }

    /**
     * @param list<string> $names
     *
     * @return list<int>
     */
    private function fetchTagIds(array $names): array
    {
        return array_map(
            fn (string $n) => $this->em->getRepository(RecipeTag::class)
                ->findOneBy(['name' => $n])?->getId()
                ?? throw new \LogicException("Tag $n not found"),
            $names
        );
    }

    /**
     * @param list<string> $names
     *
     * @return list<int>
     */
    private function fetchUtensilIds(array $names): array
    {
        return array_map(
            fn (string $n) => $this->em->getRepository(Utensil::class)
                ->findOneBy(['name' => $n])?->getId()
                ?? throw new \LogicException("Utensil $n not found"),
            $names
        );
    }

    /** @return list<RecipeIngredientInput> */
    private function makeIngredientInputs(): array
    {
        $banana = $this->em->getRepository(Ingredient::class)
            ->findOneBy(['name' => IngredientFixture::ORIGINAL_NAME]);
        $chocolate = $this->em->getRepository(Ingredient::class)
            ->findOneBy(['name' => IngredientFixture::ORIGINAL_NAME_UNUSED]);

        return [
            new RecipeIngredientInput($banana->getId(), 2, UnityEnum::GRAMS),
            new RecipeIngredientInput($chocolate->getId(), 100, UnityEnum::GRAMS),
        ];
    }

    // ───────────────────────────── Test d’erreur ─────────────────────────────
    public function testItThrowsWhenRecipeDoesNotExist(): void
    {
        $invalidId = 999_999;

        $cmd = new UpdateRecipeCommand(
            id: $invalidId,
            category: 1,
            name: 'irrelevant',
            difficulty: DifficultyEnum::HARD,
            servings: 1
        );

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Recipe #$invalidId not found.");

        ($this->handler)($cmd);
    }
}
