<?php

declare(strict_types=1);

namespace App\MessageHandler\Ingredient\Ingredient\CreateIngredient;

use App\Entity\Ingredient\Ingredient;
use App\Entity\Ingredient\IngredientMineral;
use App\Entity\Ingredient\IngredientNutritional;
use App\Entity\Ingredient\IngredientVitamine;
use App\Repository\Ingredient\IngredientCategoryRepository;
use App\Repository\Ingredient\IngredientRepository;
use App\Repository\Ingredient\IngredientTagRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(handles: CreateIngredientCommand::class)]
class CreateIngredientHandler
{
    public function __construct(
        private IngredientRepository $ingredientRepository,
        private IngredientCategoryRepository $ingredientCategoryRepository,
        private IngredientTagRepository $ingredientTagRepository,
    ) {
    }

    public function __invoke(CreateIngredientCommand $command): int
    {
        $category = $this->ingredientCategoryRepository
            ->find($command->category);

        if (!$category) {
            throw new \InvalidArgumentException(sprintf('Ingredient category #%d not found.', $command->category));
        }

        $ingredientMineral = new IngredientMineral(
            calcium: $command->minerals->calcium,
            cuivre: $command->minerals->cuivre,
            fer: $command->minerals->fer,
            iode: $command->minerals->iode,
            magnesium: $command->minerals->magnesium,
            manganese: $command->minerals->manganese,
            phosphore: $command->minerals->phosphore,
            potassium: $command->minerals->potassium,
            selenium: $command->minerals->selenium,
            sodium: $command->minerals->sodium,
            zinc: $command->minerals->zinc
        );
        $ingredientNutritional = new IngredientNutritional(
            kilocalories: $command->nutritionals->kilocalories,
            proteine: $command->nutritionals->proteine,
            glucides: $command->nutritionals->glucides,
            lipides: $command->nutritionals->lipides,
            sucres: $command->nutritionals->sucres,
            amidon: $command->nutritionals->amidon,
            fibresAlimentaires: $command->nutritionals->fibresAlimentaires,
            cholesterol: $command->nutritionals->cholesterol,
            acidesGrasSatures: $command->nutritionals->acidesGrasSatures,
            acidesGrasMonoinsatures: $command->nutritionals->acidesGrasMonoinsatures,
            acidesGrasPolyinsatures: $command->nutritionals->acidesGrasPolyinsatures,
            eau: $command->nutritionals->eau
        );
        $ingredientVitamine = new IngredientVitamine(
            vitamineA: $command->vitamines->vitamineA,
            betaCarotene: $command->vitamines->betaCarotene,
            vitamineD: $command->vitamines->vitamineD,
            vitamineE: $command->vitamines->vitamineE,
            vitamineK1: $command->vitamines->vitamineK1,
            vitamineK2: $command->vitamines->vitamineK2,
            vitamineC: $command->vitamines->vitamineC,
            vitamineB1: $command->vitamines->vitamineB1,
            vitamineB2: $command->vitamines->vitamineB2,
            vitamineB3: $command->vitamines->vitamineB3,
            vitamineB5: $command->vitamines->vitamineB5,
            vitamineB6: $command->vitamines->vitamineB6,
            vitamineB9: $command->vitamines->vitamineB9,
            vitamineB12: $command->vitamines->vitamineB12
        );

        $ingredient = new Ingredient(
            name: $command->name,
            category: $category,
            mineral: $ingredientMineral,
            nutritional: $ingredientNutritional,
            vitamine: $ingredientVitamine,
        );

        foreach ($command->tags as $tagId) {
            $tag = $this->ingredientTagRepository->find($tagId);
            if (!$tag) {
                throw new \InvalidArgumentException(sprintf('Ingredient tag #%d not found.', $tagId));
            }

            $ingredient->addTag($tag);
        }

        $this->ingredientRepository->save($ingredient);

        return $ingredient->getId();
    }
}
