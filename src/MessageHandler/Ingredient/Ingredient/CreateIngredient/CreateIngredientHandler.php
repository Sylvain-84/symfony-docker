<?php

declare(strict_types=1);

namespace App\MessageHandler\Ingredient\Ingredient\CreateIngredient;

use App\Entity\Ingredient\Ingredient;
use App\Entity\Ingredient\IngredientNutrition;
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
        $category = $this->ingredientCategoryRepository->find($command->categoryId);
        if (!$category) {
            throw new \InvalidArgumentException(sprintf('Ingredient category #%d not found.', $command->categoryId));
        }

        $nutrition = $this->createNutrition($command);

        $ingredient = new Ingredient(
            name: $command->name,
            category: $category,
            nutrition: $nutrition,
        );

        if (null !== $command->tags) {
            foreach ($command->tags as $tagId) {
                $tag = $this->ingredientTagRepository->find($tagId);
                if (!$tag) {
                    throw new \InvalidArgumentException(sprintf('Ingredient tag #%d not found.', $tagId));
                }
                $ingredient->addTag($tag);
            }
        }

        $this->ingredientRepository->save($ingredient);

        return $ingredient->getId();
    }

    private function createNutrition(CreateIngredientCommand $command): IngredientNutrition
    {
        $n = new IngredientNutrition();

        // Energy
        $n->setNrjKj((float) $command->nutrition->nrjKj);
        $n->setNrjKcal((float) $command->nutrition->nrjKcal);

        // Water & minerals
        $n->setEau((float) $command->nutrition->eau);
        $n->setSel((float) $command->nutrition->sel);
        $n->setSodium((float) $command->nutrition->sodium);
        $n->setMagnesium((float) $command->nutrition->magnesium);
        $n->setPhosphore((float) $command->nutrition->phosphore);
        $n->setPotassium((float) $command->nutrition->potassium);
        $n->setCalcium((float) $command->nutrition->calcium);
        $n->setManganese((float) $command->nutrition->manganese);
        $n->setFer((float) $command->nutrition->fer);
        $n->setCuivre((float) $command->nutrition->cuivre);
        $n->setZinc((float) $command->nutrition->zinc);
        $n->setSelenium((float) $command->nutrition->selenium);
        $n->setIode((float) $command->nutrition->iode);

        // Macronutrients
        $n->setProteines((float) $command->nutrition->proteines);
        $n->setGlucides((float) $command->nutrition->glucides);
        $n->setSucres((float) $command->nutrition->sucres);
        $n->setFructose((float) $command->nutrition->fructose);
        $n->setGalactose((float) $command->nutrition->galactose);
        $n->setLactose((float) $command->nutrition->lactose);
        $n->setGlucose((float) $command->nutrition->glucose);
        $n->setMaltose((float) $command->nutrition->maltose);
        $n->setSaccharose((float) $command->nutrition->saccharose);
        $n->setAmidon((float) $command->nutrition->amidon);
        $n->setPolyols((float) $command->nutrition->polyols);
        $n->setFibres((float) $command->nutrition->fibres);

        // Lipids
        $n->setLipides((float) $command->nutrition->lipides);
        $n->setAgs((float) $command->nutrition->ags);
        $n->setAgmi((float) $command->nutrition->agmi);
        $n->setAgpi((float) $command->nutrition->agpi);

        // Detailed fatty acids
        $n->setAg040((float) $command->nutrition->ag040);
        $n->setAg060((float) $command->nutrition->ag060);
        $n->setAg080((float) $command->nutrition->ag080);
        $n->setAg100((float) $command->nutrition->ag100);
        $n->setAg120((float) $command->nutrition->ag120);
        $n->setAg140((float) $command->nutrition->ag140);
        $n->setAg160((float) $command->nutrition->ag160);
        $n->setAg180((float) $command->nutrition->ag180);
        $n->setAg181Ole((float) $command->nutrition->ag181Ole);
        $n->setAg182Lino((float) $command->nutrition->ag182Lino);
        $n->setAg183ALino((float) $command->nutrition->ag183ALino);
        $n->setAg204Ara((float) $command->nutrition->ag204Ara);
        $n->setAg205Epa((float) $command->nutrition->ag205Epa);
        $n->setAg206Dha((float) $command->nutrition->ag206Dha);

        // Vitamins
        $n->setRetinol((float) $command->nutrition->retinol);
        $n->setBetaCarotene((float) $command->nutrition->betaCarotene);
        $n->setVitamineD((float) $command->nutrition->vitamineD);
        $n->setVitamineE((float) $command->nutrition->vitamineE);
        $n->setVitamineK1((float) $command->nutrition->vitamineK1);
        $n->setVitamineK2((float) $command->nutrition->vitamineK2);
        $n->setVitamineC((float) $command->nutrition->vitamineC);
        $n->setVitamineB1((float) $command->nutrition->vitamineB1);
        $n->setVitamineB2((float) $command->nutrition->vitamineB2);
        $n->setVitamineB3((float) $command->nutrition->vitamineB3);
        $n->setVitamineB5((float) $command->nutrition->vitamineB5);
        $n->setVitamineB6((float) $command->nutrition->vitamineB6);
        $n->setVitamineB12((float) $command->nutrition->vitamineB12);
        $n->setVitamineB9((float) $command->nutrition->vitamineB9);

        // Miscellaneous
        $n->setAlcool((float) $command->nutrition->alcool);
        $n->setAcidesOrganiques((float) $command->nutrition->acidesOrganiques);
        $n->setCholesterol((float) $command->nutrition->cholesterol);

        return $n;
    }
}
