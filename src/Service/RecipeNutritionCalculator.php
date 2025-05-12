<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Ingredient\IngredientMinerals;
use App\Entity\Ingredient\IngredientNutritionals;
use App\Entity\Ingredient\IngredientVitamines;
use App\Entity\Recipe\Recipe;

class RecipeNutritionCalculator
{
    public function getTotalNutritionals(Recipe $recipe): IngredientNutritionals
    {
        $totals = new IngredientNutritionals();

        foreach ($recipe->getRecipeIngredients() as $recipeIngredient) {
            $nutritionals = $recipeIngredient
                ->getIngredient()
                ->getNutritionals();

            if (null === $nutritionals) {
                continue;
            }

            $multiplier = $recipeIngredient->getQuantity();

            $totals->setKilocalories(
                $totals->getKilocalories()
                + $nutritionals->getKilocalories()
                * $multiplier
            );
            $totals->setProteine(
                $totals->getProteine()
                + $nutritionals->getProteine()
                * $multiplier
            );
            $totals->setGlucides(
                $totals->getGlucides()
                + $nutritionals->getGlucides()
                * $multiplier
            );
            $totals->setLipides(
                $totals->getLipides()
                + $nutritionals->getLipides()
                * $multiplier
            );
            $totals->setSucres(
                ($totals->getSucres() ?? 0)
                + ($nutritionals->getSucres() ?? 0)
                * $multiplier
            );
            $totals->setAmidon(
                ($totals->getAmidon() ?? 0)
                + ($nutritionals->getAmidon() ?? 0)
                * $multiplier
            );
            $totals->setFibresAlimentaires(
                ($totals->getFibresAlimentaires() ?? 0)
                + ($nutritionals->getFibresAlimentaires() ?? 0)
                * $multiplier
            );
            $totals->setCholesterol(
                ($totals->getCholesterol() ?? 0)
                + ($nutritionals->getCholesterol() ?? 0)
                * $multiplier
            );
            $totals->setAcidesGrasSatures(
                ($totals->getAcidesGrasSatures() ?? 0)
                + ($nutritionals->getAcidesGrasSatures() ?? 0)
                * $multiplier
            );
            $totals->setAcidesGrasMonoinsatures(
                ($totals->getAcidesGrasMonoinsatures() ?? 0)
                + ($nutritionals->getAcidesGrasMonoinsatures() ?? 0)
                * $multiplier
            );
            $totals->setAcidesGrasPolyinsatures(
                ($totals->getAcidesGrasPolyinsatures() ?? 0)
                + ($nutritionals->getAcidesGrasPolyinsatures() ?? 0)
                * $multiplier
            );
            $totals->setEau(
                ($totals->getEau() ?? 0)
                + ($nutritionals->getEau() ?? 0)
                * $multiplier
            );
        }

        return $totals;
    }

    public function getNutritionalsPerServing(Recipe $recipe): IngredientNutritionals
    {
        $perServing = $this->getTotalNutritionals($recipe);
        $divisor = max(1, $recipe->getServings()); // avoid /0

        $perServing->setKilocalories($perServing->getKilocalories() / $divisor);
        $perServing->setProteine($perServing->getProteine() / $divisor);
        $perServing->setGlucides($perServing->getGlucides() / $divisor);
        $perServing->setLipides($perServing->getLipides() / $divisor);
        $perServing->setSucres(($perServing->getSucres() ?? 0) / $divisor);
        $perServing->setAmidon(($perServing->getAmidon() ?? 0) / $divisor);
        $perServing->setFibresAlimentaires(($perServing->getFibresAlimentaires() ?? 0) / $divisor);
        $perServing->setCholesterol(($perServing->getCholesterol() ?? 0) / $divisor);
        $perServing->setAcidesGrasSatures(($perServing->getAcidesGrasSatures() ?? 0) / $divisor);
        $perServing->setAcidesGrasMonoinsatures(($perServing->getAcidesGrasMonoinsatures() ?? 0) / $divisor);
        $perServing->setAcidesGrasPolyinsatures(($perServing->getAcidesGrasPolyinsatures() ?? 0) / $divisor);
        $perServing->setEau(($perServing->getEau() ?? 0) / $divisor);

        return $perServing;
    }

    public function getTotalMinerals(Recipe $recipe): IngredientMinerals
    {
        $totalMinerals = new IngredientMinerals();   // everything starts at null

        foreach ($recipe->getRecipeIngredients() as $recipeIngredient) {
            $ingredientMinerals = $recipeIngredient
                ->getIngredient()
                ->getMinerals();

            if (null === $ingredientMinerals) {
                continue;     // nothing to add
            }

            $multiplier = $recipeIngredient->getQuantity();

            // 1. Calcium
            $totalMinerals->setCalcium(
                ($totalMinerals->getCalcium() ?? 0.0)
                + ($ingredientMinerals->getCalcium() ?? 0.0)
                * $multiplier
            );

            // 2. Copper
            $totalMinerals->setCuivre(
                ($totalMinerals->getCuivre() ?? 0.0)
                + ($ingredientMinerals->getCuivre() ?? 0.0)
                * $multiplier
            );

            // 3. Iron
            $totalMinerals->setFer(
                ($totalMinerals->getFer() ?? 0.0)
                + ($ingredientMinerals->getFer() ?? 0.0)
                * $multiplier
            );

            // 4. Iodine
            $totalMinerals->setIode(
                ($totalMinerals->getIode() ?? 0.0)
                + ($ingredientMinerals->getIode() ?? 0.0)
                * $multiplier
            );

            // 5. Magnesium
            $totalMinerals->setMagnesium(
                ($totalMinerals->getMagnesium() ?? 0.0)
                + ($ingredientMinerals->getMagnesium() ?? 0.0)
                * $multiplier
            );

            // 6. Manganese
            $totalMinerals->setManganese(
                ($totalMinerals->getManganese() ?? 0.0)
                + ($ingredientMinerals->getManganese() ?? 0.0)
                * $multiplier
            );

            // 7. Phosphorus
            $totalMinerals->setPhosphore(
                ($totalMinerals->getPhosphore() ?? 0.0)
                + ($ingredientMinerals->getPhosphore() ?? 0.0)
                * $multiplier
            );

            // 8. Potassium
            $totalMinerals->setPotassium(
                ($totalMinerals->getPotassium() ?? 0.0)
                + ($ingredientMinerals->getPotassium() ?? 0.0)
                * $multiplier
            );

            // 9. Selenium
            $totalMinerals->setSelenium(
                ($totalMinerals->getSelenium() ?? 0.0)
                + ($ingredientMinerals->getSelenium() ?? 0.0)
                * $multiplier
            );

            // 10. Sodium
            $totalMinerals->setSodium(
                ($totalMinerals->getSodium() ?? 0.0)
                + ($ingredientMinerals->getSodium() ?? 0.0)
                * $multiplier
            );

            // 11. Zinc
            $totalMinerals->setZinc(
                ($totalMinerals->getZinc() ?? 0.0)
                + ($ingredientMinerals->getZinc() ?? 0.0)
                * $multiplier
            );
        }

        return $totalMinerals;
    }

    public function getMineralsPerServing(Recipe $recipe): IngredientMinerals
    {
        $mineralsPerServing = $this->getTotalMinerals($recipe);
        $divisor = max(1, $recipe->getServings());

        // divide every field by the number of servings
        $mineralsPerServing->setCalcium(($mineralsPerServing->getCalcium() ?? 0.0) / $divisor);
        $mineralsPerServing->setCuivre(($mineralsPerServing->getCuivre() ?? 0.0) / $divisor);
        $mineralsPerServing->setFer(($mineralsPerServing->getFer() ?? 0.0) / $divisor);
        $mineralsPerServing->setIode(($mineralsPerServing->getIode() ?? 0.0) / $divisor);
        $mineralsPerServing->setMagnesium(($mineralsPerServing->getMagnesium() ?? 0.0) / $divisor);
        $mineralsPerServing->setManganese(($mineralsPerServing->getManganese() ?? 0.0) / $divisor);
        $mineralsPerServing->setPhosphore(($mineralsPerServing->getPhosphore() ?? 0.0) / $divisor);
        $mineralsPerServing->setPotassium(($mineralsPerServing->getPotassium() ?? 0.0) / $divisor);
        $mineralsPerServing->setSelenium(($mineralsPerServing->getSelenium() ?? 0.0) / $divisor);
        $mineralsPerServing->setSodium(($mineralsPerServing->getSodium() ?? 0.0) / $divisor);
        $mineralsPerServing->setZinc(($mineralsPerServing->getZinc() ?? 0.0) / $divisor);

        return $mineralsPerServing;
    }

    public function getTotalVitamins(Recipe $recipe): IngredientVitamines
    {
        $totalVitamins = new IngredientVitamines();  // every field starts at null

        foreach ($recipe->getRecipeIngredients() as $recipeIngredient) {
            $ingredientVitamins = $recipeIngredient
                ->getIngredient()
                ->getVitamines();

            if (null === $ingredientVitamins) {
                continue;   // nothing to merge
            }

            $multiplier = $recipeIngredient->getQuantity();

            // 1. Vit A
            $totalVitamins->setVitamineA(
                ($totalVitamins->getVitamineA() ?? 0.0)
                + ($ingredientVitamins->getVitamineA() ?? 0.0)
                * $multiplier
            );

            // 2. Beta-carotene
            $totalVitamins->setBetaCarotene(
                ($totalVitamins->getBetaCarotene() ?? 0.0)
                + ($ingredientVitamins->getBetaCarotene() ?? 0.0)
                * $multiplier
            );

            // 3. Vit D
            $totalVitamins->setVitamineD(
                ($totalVitamins->getVitamineD() ?? 0.0)
                + ($ingredientVitamins->getVitamineD() ?? 0.0)
                * $multiplier
            );

            // 4. Vit E
            $totalVitamins->setVitamineE(
                ($totalVitamins->getVitamineE() ?? 0.0)
                + ($ingredientVitamins->getVitamineE() ?? 0.0)
                * $multiplier
            );

            // 5. Vit K1
            $totalVitamins->setVitamineK1(
                ($totalVitamins->getVitamineK1() ?? 0.0)
                + ($ingredientVitamins->getVitamineK1() ?? 0.0)
                * $multiplier
            );

            // 6. Vit K2
            $totalVitamins->setVitamineK2(
                ($totalVitamins->getVitamineK2() ?? 0.0)
                + ($ingredientVitamins->getVitamineK2() ?? 0.0)
                * $multiplier
            );

            // 7. Vit C
            $totalVitamins->setVitamineC(
                ($totalVitamins->getVitamineC() ?? 0.0)
                + ($ingredientVitamins->getVitamineC() ?? 0.0)
                * $multiplier
            );

            // 8. Vit B1
            $totalVitamins->setVitamineB1(
                ($totalVitamins->getVitamineB1() ?? 0.0)
                + ($ingredientVitamins->getVitamineB1() ?? 0.0)
                * $multiplier
            );

            // 9. Vit B2
            $totalVitamins->setVitamineB2(
                ($totalVitamins->getVitamineB2() ?? 0.0)
                + ($ingredientVitamins->getVitamineB2() ?? 0.0)
                * $multiplier
            );

            // 10. Vit B3
            $totalVitamins->setVitamineB3(
                ($totalVitamins->getVitamineB3() ?? 0.0)
                + ($ingredientVitamins->getVitamineB3() ?? 0.0)
                * $multiplier
            );

            // 11. Vit B5
            $totalVitamins->setVitamineB5(
                ($totalVitamins->getVitamineB5() ?? 0.0)
                + ($ingredientVitamins->getVitamineB5() ?? 0.0)
                * $multiplier
            );

            // 12. Vit B6
            $totalVitamins->setVitamineB6(
                ($totalVitamins->getVitamineB6() ?? 0.0)
                + ($ingredientVitamins->getVitamineB6() ?? 0.0)
                * $multiplier
            );

            // 13. Vit B9 (folates)
            $totalVitamins->setVitamineB9(
                ($totalVitamins->getVitamineB9() ?? 0.0)
                + ($ingredientVitamins->getVitamineB9() ?? 0.0)
                * $multiplier
            );

            // 14. Vit B12
            $totalVitamins->setVitamineB12(
                ($totalVitamins->getVitamineB12() ?? 0.0)
                + ($ingredientVitamins->getVitamineB12() ?? 0.0)
                * $multiplier
            );
        }

        return $totalVitamins;
    }

    public function getVitaminsPerServing(Recipe $recipe): IngredientVitamines
    {
        $vitaminsPerServing = $this->getTotalVitamins($recipe);
        $divisor = max(1, $recipe->getServings());

        // divide every field by the number of servings
        $vitaminsPerServing->setVitamineA(($vitaminsPerServing->getVitamineA() ?? 0.0) / $divisor);
        $vitaminsPerServing->setBetaCarotene(($vitaminsPerServing->getBetaCarotene() ?? 0.0) / $divisor);
        $vitaminsPerServing->setVitamineD(($vitaminsPerServing->getVitamineD() ?? 0.0) / $divisor);
        $vitaminsPerServing->setVitamineE(($vitaminsPerServing->getVitamineE() ?? 0.0) / $divisor);
        $vitaminsPerServing->setVitamineK1(($vitaminsPerServing->getVitamineK1() ?? 0.0) / $divisor);
        $vitaminsPerServing->setVitamineK2(($vitaminsPerServing->getVitamineK2() ?? 0.0) / $divisor);
        $vitaminsPerServing->setVitamineC(($vitaminsPerServing->getVitamineC() ?? 0.0) / $divisor);
        $vitaminsPerServing->setVitamineB1(($vitaminsPerServing->getVitamineB1() ?? 0.0) / $divisor);
        $vitaminsPerServing->setVitamineB2(($vitaminsPerServing->getVitamineB2() ?? 0.0) / $divisor);
        $vitaminsPerServing->setVitamineB3(($vitaminsPerServing->getVitamineB3() ?? 0.0) / $divisor);
        $vitaminsPerServing->setVitamineB5(($vitaminsPerServing->getVitamineB5() ?? 0.0) / $divisor);
        $vitaminsPerServing->setVitamineB6(($vitaminsPerServing->getVitamineB6() ?? 0.0) / $divisor);
        $vitaminsPerServing->setVitamineB9(($vitaminsPerServing->getVitamineB9() ?? 0.0) / $divisor);
        $vitaminsPerServing->setVitamineB12(($vitaminsPerServing->getVitamineB12() ?? 0.0) / $divisor);

        return $vitaminsPerServing;
    }
}
