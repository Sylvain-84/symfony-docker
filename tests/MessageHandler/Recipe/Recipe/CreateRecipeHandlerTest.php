<?php

declare(strict_types=1);

namespace App\Tests\MessageHandler\Recipe\Recipe;

use App\DataFixtures\Recipe\RecipeCategoryFixture;
use App\DataFixtures\Recipe\RecipeTagFixture;
use App\DataFixtures\Recipe\UtensilFixture;
use App\Entity\Recipe\Recipe;
use App\Entity\Recipe\RecipeCategory;
use App\Entity\Recipe\RecipeTag;
use App\Entity\Recipe\Utensil;
use App\Enum\DifficultyEnum;
use App\MessageHandler\Recipe\Recipe\CreateRecipe\CreateRecipeCommand;
use App\MessageHandler\Recipe\Recipe\CreateRecipe\CreateRecipeHandler;
use App\MessageHandler\Recipe\Recipe\InstructionInput;
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
        /** @var ?RecipeCategory $category */
        $category = $this->em->getRepository(RecipeCategory::class)
            ->findOneBy(['name' => RecipeCategoryFixture::ORIGINAL_NAME]);

        self::assertNotNull($category, 'La catégorie de la fixture n’a pas été trouvée');

        $tag = $this->em->getRepository(RecipeTag::class)
            ->findOneBy(['name' => RecipeTagFixture::ORIGINAL_NAME]);
        $tag2 = $this->em->getRepository(RecipeTag::class)
            ->findOneBy(['name' => RecipeTagFixture::ORIGINAL_NAME_2]);

        $utensil = $this->em->getRepository(Utensil::class)
            ->findOneBy(['name' => UtensilFixture::ORIGINAL_NAME]);
        $utensil2 = $this->em->getRepository(Utensil::class)
            ->findOneBy(['name' => UtensilFixture::ORIGINAL_NAME_2]);

        $instructions = [
            new InstructionInput('Préparer', 'Coupez les bananes en rondelles', 1),
            new InstructionInput('Mélanger', 'Ajoutez le chocolat et mélangez', 2),
            new InstructionInput('Servir', 'Dressez dans les assiettes', 3),
        ];
        $command = new CreateRecipeCommand(
            name: 'Banana dark chocolate',
            category: $category->getId(),
            difficulty: DifficultyEnum::EASY,
            servings: 3,
            preparationTime: 20,
            cookingTime: 0,
            description: 'It is a recipe with banana dark chocolate',
            tags: [$tag->getId(), $tag2->getId()],
            utensils: [$utensil->getId(), $utensil2->getId()],
            note: 7,
            instructions: $instructions
        );

        $returnedId = ($this->handler)($command);

        /** @var ?Recipe $recipe */
        $recipe = $this->em->getRepository(Recipe::class)->find($returnedId);

        self::assertNotNull($recipe, 'Recipe should have been persisted');
        self::assertSame('Banana dark chocolate', $recipe->getName());
        self::assertSame('It is a recipe with banana dark chocolate', $recipe->getDescription());
        self::assertSame($category->getId(), $recipe->getCategory()->getId());
        self::assertCount(2, $recipe->getTags(), 'Recipe should have 2 tags');
        self::assertSame($tag->getId(), $recipe->getTags()->first()->getId());
        self::assertSame($tag2->getId(), $recipe->getTags()->get(1)->getId());
        self::assertSame(DifficultyEnum::EASY, $recipe->getDifficulty());
        self::assertSame(3, $recipe->getServings());
        self::assertSame(20, $recipe->getPreparationTime());
        self::assertSame(0, $recipe->getCookingTime());
        self::assertCount(2, $recipe->getUtensils(), 'Recipe should have 2 utensils');
        self::assertSame($utensil->getId(), $recipe->getUtensils()->first()->getId());
        self::assertSame($utensil2->getId(), $recipe->getUtensils()->get(1)->getId());
        self::assertSame(7, $recipe->getNote());
        self::assertCount(3, $recipe->getInstructions(), 'Recipe should have 3 instructions');
        self::assertSame('Préparer', $recipe->getInstructions()->first()->getName());
        self::assertSame(3, $recipe->getInstructions()->last()->getPosition());
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
