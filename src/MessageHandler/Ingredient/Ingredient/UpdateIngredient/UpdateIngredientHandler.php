<?php

declare(strict_types=1);

namespace App\MessageHandler\Ingredient\Ingredient\UpdateIngredient;

use App\Entity\Ingredient\Ingredient;
use App\Entity\Ingredient\IngredientNutrition;
use App\Repository\Ingredient\IngredientCategoryRepository;
use App\Repository\Ingredient\IngredientRepository;
use App\Repository\Ingredient\IngredientTagRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(handles: UpdateIngredientCommand::class)]
class UpdateIngredientHandler
{
    public function __construct(
        private IngredientRepository $ingredientRepository,
        private IngredientCategoryRepository $ingredientCategoryRepository,
        private IngredientTagRepository $ingredientTagRepository,
    ) {
    }

    public function __invoke(UpdateIngredientCommand $command): void
    {
        $ingredient = $this->ingredientRepository->find($command->id);
        if (!$ingredient) {
            throw new \InvalidArgumentException(sprintf('Ingredient #%d not found.', $command->id));
        }

        $category = $this->ingredientCategoryRepository->find($command->categoryId);
        if (!$category) {
            throw new \InvalidArgumentException(sprintf('Ingredient category #%d not found.', $command->categoryId));
        }

        $ingredient->setCategory($category);
        $ingredient->setName($command->name);

        // update/create the single Nutrition entity
        $nutrition = $this->updateNutrition($ingredient, $command);
        $ingredient->setNutrition($nutrition);

        // update tags
        $this->applyTags($command, $ingredient);

        $this->ingredientRepository->save($ingredient);
    }

    private function updateNutrition(Ingredient $ingredient, UpdateIngredientCommand $command): IngredientNutrition
    {
        // reuse existing or create new
        $nutrition = $ingredient->getNutrition();

        // Energy
        $nutrition->setNrjKj((float) $command->nutrition->nrjKj);
        $nutrition->setNrjKcal((float) $command->nutrition->nrjKcal);

        // Water & minerals
        $nutrition->setEau((float) $command->nutrition->eau);
        $nutrition->setSel((float) $command->nutrition->sel);
        $nutrition->setSodium((float) $command->nutrition->sodium);
        $nutrition->setMagnesium((float) $command->nutrition->magnesium);
        $nutrition->setPhosphore((float) $command->nutrition->phosphore);
        $nutrition->setPotassium((float) $command->nutrition->potassium);
        $nutrition->setCalcium((float) $command->nutrition->calcium);
        $nutrition->setManganese((float) $command->nutrition->manganese);
        $nutrition->setFer((float) $command->nutrition->fer);
        $nutrition->setCuivre((float) $command->nutrition->cuivre);
        $nutrition->setZinc((float) $command->nutrition->zinc);
        $nutrition->setSelenium((float) $command->nutrition->selenium);
        $nutrition->setIode((float) $command->nutrition->iode);

        // Macronutrients
        $nutrition->setProteines((float) $command->nutrition->proteines);
        $nutrition->setGlucides((float) $command->nutrition->glucides);
        $nutrition->setLipides((float) $command->nutrition->lipides);
        $nutrition->setSucres((float) $command->nutrition->sucres);
        $nutrition->setFructose((float) $command->nutrition->fructose);
        $nutrition->setGalactose((float) $command->nutrition->galactose);
        $nutrition->setLactose((float) $command->nutrition->lactose);
        $nutrition->setGlucose((float) $command->nutrition->glucose);
        $nutrition->setMaltose((float) $command->nutrition->maltose);
        $nutrition->setSaccharose((float) $command->nutrition->saccharose);
        $nutrition->setAmidon((float) $command->nutrition->amidon);
        $nutrition->setPolyols((float) $command->nutrition->polyols);
        $nutrition->setFibres((float) $command->nutrition->fibres);

        // Fatty acids
        $nutrition->setAgs((float) $command->nutrition->ags);
        $nutrition->setAgmi((float) $command->nutrition->agmi);
        $nutrition->setAgpi((float) $command->nutrition->agpi);
        $nutrition->setAg040((float) $command->nutrition->ag040);
        $nutrition->setAg060((float) $command->nutrition->ag060);
        $nutrition->setAg080((float) $command->nutrition->ag080);
        $nutrition->setAg100((float) $command->nutrition->ag100);
        $nutrition->setAg120((float) $command->nutrition->ag120);
        $nutrition->setAg140((float) $command->nutrition->ag140);
        $nutrition->setAg160((float) $command->nutrition->ag160);
        $nutrition->setAg180((float) $command->nutrition->ag180);
        $nutrition->setAg181Ole((float) $command->nutrition->ag181Ole);
        $nutrition->setAg182Lino((float) $command->nutrition->ag182Lino);
        $nutrition->setAg183ALino((float) $command->nutrition->ag183ALino);
        $nutrition->setAg204Ara((float) $command->nutrition->ag204Ara);
        $nutrition->setAg205Epa((float) $command->nutrition->ag205Epa);
        $nutrition->setAg206Dha((float) $command->nutrition->ag206Dha);

        // Vitamins
        $nutrition->setRetinol((float) $command->nutrition->retinol);
        $nutrition->setBetaCarotene((float) $command->nutrition->betaCarotene);
        $nutrition->setVitamineD((float) $command->nutrition->vitamineD);
        $nutrition->setVitamineE((float) $command->nutrition->vitamineE);
        $nutrition->setVitamineK1((float) $command->nutrition->vitamineK1);
        $nutrition->setVitamineK2((float) $command->nutrition->vitamineK2);
        $nutrition->setVitamineC((float) $command->nutrition->vitamineC);
        $nutrition->setVitamineB1((float) $command->nutrition->vitamineB1);
        $nutrition->setVitamineB2((float) $command->nutrition->vitamineB2);
        $nutrition->setVitamineB3((float) $command->nutrition->vitamineB3);
        $nutrition->setVitamineB5((float) $command->nutrition->vitamineB5);
        $nutrition->setVitamineB6((float) $command->nutrition->vitamineB6);
        $nutrition->setVitamineB12((float) $command->nutrition->vitamineB12);
        $nutrition->setVitamineB9((float) $command->nutrition->vitamineB9);

        // Misc
        $nutrition->setAlcool((float) $command->nutrition->alcool);
        $nutrition->setAcidesOrganiques((float) $command->nutrition->acidesOrganiques);
        $nutrition->setCholesterol((float) $command->nutrition->cholesterol);

        return $nutrition;
    }

    private function applyTags(UpdateIngredientCommand $command, Ingredient $ingredient): void
    {
        $ingredient->clearTags();

        if (null === $command->tags) {
            return;
        }

        foreach ($command->tags as $tagId) {
            $tag = $this->ingredientTagRepository->find($tagId);
            if (!$tag) {
                throw new \InvalidArgumentException(sprintf('Ingredient tag #%d not found.', $tagId));
            }
            $ingredient->addTag($tag);
        }
    }
}
