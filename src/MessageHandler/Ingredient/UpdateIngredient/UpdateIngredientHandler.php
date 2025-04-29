<?php

namespace App\MessageHandler\Ingredient\UpdateIngredient;

use App\Entity\Ingredient;
use App\Repository\IngredientCategoryRepository;
use App\Repository\IngredientRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(handles: UpdateIngredientCommand::class)]
class UpdateIngredientHandler
{
    public function __construct(
        private IngredientRepository         $ingredientRepository,
        private IngredientCategoryRepository $ingredientCategoryRepository,
    ) {
    }

    public function __invoke(UpdateIngredientCommand $command): void
    {
        /** ----------------------------------------------------------------
         * 1. Fetch the ingredient to update
         * ---------------------------------------------------------------- */
        $ingredient = $this->ingredientRepository->find($command->id);

        if (!$ingredient) {
            throw new \InvalidArgumentException(sprintf(
                'Ingredient #%d not found.',
                $command->id
            ));
        }

        /** ----------------------------------------------------------------
         * 2. Validate / update the category
         * ---------------------------------------------------------------- */
        $category = $this->ingredientCategoryRepository->find($command->category);
        if (!$category) {
            throw new \InvalidArgumentException(sprintf(
                'Ingredient category #%d not found.',
                $command->category
            ));
        }
        $ingredient->setCategory($category);

        /** ----------------------------------------------------------------
         * 3. Scalar fields on Ingredient
         * ---------------------------------------------------------------- */
        $ingredient->setName($command->name);

        /** ----------------------------------------------------------------
         * 4. Minerals
         * ---------------------------------------------------------------- */
        $mineral = $ingredient->getMineral();
        $mineral->setCalcium($command->minerals->calcium);
        $mineral->setCuivre($command->minerals->cuivre);
        $mineral->setFer($command->minerals->fer);
        $mineral->setIode($command->minerals->iode);
        $mineral->setMagnesium($command->minerals->magnesium);
        $mineral->setManganese($command->minerals->manganese);
        $mineral->setPhosphore($command->minerals->phosphore);
        $mineral->setPotassium($command->minerals->potassium);
        $mineral->setSelenium($command->minerals->selenium);
        $mineral->setSodium($command->minerals->sodium);
        $mineral->setZinc($command->minerals->zinc);

        /** ----------------------------------------------------------------
         * 5. Nutritionals
         * ---------------------------------------------------------------- */
        $nutritional = $ingredient->getNutritional();
        $nutritional->setKilocalories($command->nutritionals->kilocalories);
        $nutritional->setProteine($command->nutritionals->proteine);
        $nutritional->setGlucides($command->nutritionals->glucides);
        $nutritional->setLipides($command->nutritionals->lipides);
        $nutritional->setSucres($command->nutritionals->sucres);
        $nutritional->setAmidon($command->nutritionals->amidon);
        $nutritional->setFibresAlimentaires($command->nutritionals->fibresAlimentaires);
        $nutritional->setCholesterol($command->nutritionals->cholesterol);
        $nutritional->setAcidesGrasSatures($command->nutritionals->acidesGrasSatures);
        $nutritional->setAcidesGrasMonoinsatures($command->nutritionals->acidesGrasMonoinsatures);
        $nutritional->setAcidesGrasPolyinsatures($command->nutritionals->acidesGrasPolyinsatures);
        $nutritional->setEau($command->nutritionals->eau);

        /** ----------------------------------------------------------------
         * 6. Vitamins
         * ---------------------------------------------------------------- */
        $vitamine = $ingredient->getVitamine();
        $vitamine->setVitamineA($command->vitamines->vitamineA);
        $vitamine->setBetaCarotene($command->vitamines->betaCarotene);
        $vitamine->setVitamineD($command->vitamines->vitamineD);
        $vitamine->setVitamineE($command->vitamines->vitamineE);
        $vitamine->setVitamineK1($command->vitamines->vitamineK1);
        $vitamine->setVitamineK2($command->vitamines->vitamineK2);
        $vitamine->setVitamineC($command->vitamines->vitamineC);
        $vitamine->setVitamineB1($command->vitamines->vitamineB1);
        $vitamine->setVitamineB2($command->vitamines->vitamineB2);
        $vitamine->setVitamineB3($command->vitamines->vitamineB3);
        $vitamine->setVitamineB5($command->vitamines->vitamineB5);
        $vitamine->setVitamineB6($command->vitamines->vitamineB6);
        $vitamine->setVitamineB9($command->vitamines->vitamineB9);
        $vitamine->setVitamineB12($command->vitamines->vitamineB12);

        /** ----------------------------------------------------------------
         * 7. Persist & return the id
         * ---------------------------------------------------------------- */
        $this->ingredientRepository->save($ingredient);
    }
}
