<?php

declare(strict_types=1);

namespace App\MessageHandler\Ingredient\UpdateIngredient;

use App\Entity\Ingredient;
use App\Entity\IngredientMineral;
use App\Entity\IngredientNutritional;
use App\Entity\IngredientVitamine;
use App\Repository\IngredientCategoryRepository;
use App\Repository\IngredientRepository;
use App\Repository\IngredientTagRepository;
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

        $category = $this->ingredientCategoryRepository->find($command->category);
        if (!$category) {
            throw new \InvalidArgumentException(sprintf('Ingredient category #%d not found.', $command->category));
        }

        $ingredient->setCategory($category);
        $ingredient->setName($command->name);

        $mineral = $this->mineral($ingredient, $command);
        $nutritional = $this->nutritional($ingredient, $command);
        $vitamine = $this->vitamine($ingredient, $command);

        foreach ($command->tags as $tagId) {
            $tag = $this->ingredientTagRepository->find($tagId);
            if (!$tag) {
                throw new \InvalidArgumentException(sprintf('Ingredient tag #%d not found.', $tagId));
            }

            $ingredient->addTag($tag);
        }

        $this->ingredientRepository->save($ingredient);
    }

    public function mineral(Ingredient $ingredient, UpdateIngredientCommand $command): IngredientMineral
    {
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

        return $mineral;
    }

    public function nutritional(Ingredient $ingredient, UpdateIngredientCommand $command): IngredientNutritional
    {
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

        return $nutritional;
    }

    public function vitamine(Ingredient $ingredient, UpdateIngredientCommand $command): IngredientVitamine
    {
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

        return $vitamine;
    }
}
