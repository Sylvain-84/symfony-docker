<?php

declare(strict_types=1);

namespace App\Tests\MessageHandler\Recipe\Recipe;

use App\DataFixtures\Ingredient\IngredientFixture;
use App\DataFixtures\Recipe\RecipeCategoryFixture;
use App\DataFixtures\Recipe\RecipeTagFixture;
use App\DataFixtures\Recipe\UtensilFixture;
use App\Entity\Ingredient\Ingredient;
use App\Entity\Recipe\Recipe;
use App\Entity\Recipe\RecipeCategory;
use App\Entity\Recipe\RecipeTag;
use App\Entity\Recipe\Utensil;
use App\Enum\DifficultyEnum;
use App\Enum\UnityEnum;
use App\MessageHandler\Recipe\Recipe\CreateRecipe\CreateRecipeCommand;
use App\MessageHandler\Recipe\Recipe\CreateRecipe\CreateRecipeHandler;
use App\MessageHandler\Recipe\Recipe\InstructionInput;
use App\MessageHandler\Recipe\Recipe\RecipeIngredientInput;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @covers \App\MessageHandler\Recipe\Recipe\CreateRecipe\CreateRecipeHandler
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

        $this->em->beginTransaction();

        // Charge toutes les fixtures nécessaires
        $loader = new Loader();
        $loader->addFixture(new RecipeCategoryFixture());
        $loader->addFixture(new RecipeTagFixture());
        $loader->addFixture(new UtensilFixture());
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

    // ─────────────────────────── TEST PRINCIPAL ────────────────────────────
    public function testItCreatesARecipe(): void
    {
        $category = $this->fetchCategory(RecipeCategoryFixture::ORIGINAL_NAME);
        $tagIds = $this->fetchTagIds([RecipeTagFixture::ORIGINAL_NAME, RecipeTagFixture::ORIGINAL_NAME_2]);
        $utensilIds = $this->fetchUtensilIds([UtensilFixture::ORIGINAL_NAME, UtensilFixture::ORIGINAL_NAME_2]);
        $instructions = [
            new InstructionInput('Préparer', 'Coupez les bananes en rondelles', 1),
            new InstructionInput('Mélanger', 'Ajoutez le chocolat et mélangez', 2),
            new InstructionInput('Servir', 'Dressez dans les assiettes', 3),
        ];
        $ingredients = $this->makeIngredientInputs();

        $cmd = new CreateRecipeCommand(
            name: 'Banana dark chocolate',
            category: $category->getId(),
            difficulty: DifficultyEnum::EASY,
            servings: 3,
            preparationTime: 20,
            cookingTime: 0,
            description: 'It is a recipe with banana dark chocolate',
            tags: $tagIds,
            utensils: $utensilIds,
            note: 7,
            instructions: $instructions,
            ingredients: $ingredients,
        );

        $recipeId = ($this->handler)($cmd);

        /** @var ?Recipe $recipe */
        $recipe = $this->em->getRepository(Recipe::class)->find($recipeId);

        // ─── Assertions simples ───────────────────────────────────────────
        self::assertNotNull($recipe);
        self::assertSame('Banana dark chocolate', $recipe->getName());
        self::assertSame('It is a recipe with banana dark chocolate', $recipe->getDescription());
        self::assertSame(DifficultyEnum::EASY, $recipe->getDifficulty());
        self::assertSame(3, $recipe->getServings());
        self::assertSame(20, $recipe->getPreparationTime());
        self::assertSame(0, $recipe->getCookingTime());
        self::assertSame(7, $recipe->getNote());
        self::assertSame($category->getId(), $recipe->getCategory()->getId());

        // Tags & utensils : comparaison de listes d’IDs
        self::assertEqualsCanonicalizing(
            $tagIds,
            $recipe->getTags()->map(fn (RecipeTag $t) => $t->getId())->toArray()
        );
        self::assertEqualsCanonicalizing(
            $utensilIds,
            $recipe->getUtensils()->map(fn (Utensil $u) => $u->getId())->toArray()
        );

        // Instructions
        self::assertCount(3, $recipe->getInstructions());
        self::assertSame('Préparer', $recipe->getInstructions()->first()->getName());
        self::assertSame(3, $recipe->getInstructions()->last()->getPosition());

        // Ingredients
        self::assertCount(2, $recipe->getIngredients());
        $firstIng = $recipe->getIngredients()->first();
        self::assertSame(2.0, $firstIng->getQuantity());
        self::assertSame(UnityEnum::GRAMS, $firstIng->getUnit());
    }

    // ─────────────────────────── Helpers privés ────────────────────────────
    private function fetchCategory(string $name): RecipeCategory
    {
        return $this->em->getRepository(RecipeCategory::class)->findOneBy(['name' => $name])
            ?? throw new \LogicException("Category $name not found");
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
            ->findOneBy(['name' => IngredientFixture::ORIGINAL_NAME_2]);

        return [
            new RecipeIngredientInput($banana->getId(), 2, UnityEnum::GRAMS),
            new RecipeIngredientInput($chocolate->getId(), 100, UnityEnum::GRAMS),
        ];
    }

    // ─────────────────────────── Test d’erreur ────────────────────────────
    public function testItThrowsWhenCategoryDoesNotExist(): void
    {
        $invalidCategory = 999_999;

        $cmd = new CreateRecipeCommand(
            name: 'irrelevant',
            category: $invalidCategory,
            difficulty: DifficultyEnum::EASY,
            servings: 1
        );

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Recipe category #$invalidCategory not found.");

        ($this->handler)($cmd);
    }
}
