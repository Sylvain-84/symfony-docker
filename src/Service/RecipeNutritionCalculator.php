<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Ingredient\IngredientNutrition;
use App\Entity\Recipe\Recipe;

class RecipeNutritionCalculator
{
    public function getTotalNutrition(Recipe $recipe): IngredientNutrition
    {
        $totals = new IngredientNutrition();

        foreach ($recipe->getRecipeIngredients() as $ri) {
            $nutrition = $ri->getIngredient()->getNutrition();
            $multiplier = $ri->getQuantity();

            foreach (array_keys(IngredientNutrition::UNITS) as $property) {
                $getter = 'get' . ucfirst($property);
                $setter = 'set' . ucfirst($property);

                if (!method_exists($nutrition, $getter) || !method_exists($totals, $setter)) {
                    continue;
                }

                $current = $totals->$getter() ?? 0.0;
                $toAdd = $nutrition->$getter() ?? 0.0;
                $totals->$setter($current + $toAdd * $multiplier);
            }
        }

        return $totals;
    }

    public function getNutritionPerServing(Recipe $recipe): IngredientNutrition
    {
        $perServing = $this->getTotalNutrition($recipe);
        $divisor = max(1, $recipe->getServings());

        foreach (array_keys(IngredientNutrition::UNITS) as $property) {
            $getter = 'get' . ucfirst($property);
            $setter = 'set' . ucfirst($property);

            if (!method_exists($perServing, $getter) || !method_exists($perServing, $setter)) {
                continue;
            }

            $value = $perServing->$getter() ?? 0.0;
            $perServing->$setter($value / $divisor);
        }

        return $perServing;
    }
}

// class RecipeNutritionCalculator
// {
//    public function getTotalNutritionals(Recipe $recipe): IngredientNutrition
//    {
//        $totals = new IngredientNutrition();
//
//        foreach ($recipe->getRecipeIngredients() as $ri) {
//            $nutrition = $ri->getIngredient()->getNutrition();
//            if (null === $nutrition) {
//                continue;
//            }
//
//            $qty = $ri->getQuantity();
//
//            // Energy
//            $totals->setNrjKj(
//                $totals->getNrjKj()
//                + $nutrition->getNrjKj() * $qty
//            );
//            $totals->setNrjKcal(
//                $totals->getNrjKcal()
//                + $nutrition->getNrjKcal() * $qty
//            );
//
//            // Water & minerals
//            $totals->setEau(
//                $totals->getEau()
//                + $nutrition->getEau() * $qty
//            );
//            $totals->setSel(
//                $totals->getSel()
//                + $nutrition->getSel() * $qty
//            );
//            $totals->setSodium(
//                $totals->getSodium()
//                + $nutrition->getSodium() * $qty
//            );
//            $totals->setMagnesium(
//                $totals->getMagnesium()
//                + $nutrition->getMagnesium() * $qty
//            );
//            $totals->setPhosphore(
//                $totals->getPhosphore()
//                + $nutrition->getPhosphore() * $qty
//            );
//            $totals->setPotassium(
//                $totals->getPotassium()
//                + $nutrition->getPotassium() * $qty
//            );
//            $totals->setCalcium(
//                $totals->getCalcium()
//                + $nutrition->getCalcium() * $qty
//            );
//            $totals->setManganese(
//                $totals->getManganese()
//                + $nutrition->getManganese() * $qty
//            );
//            $totals->setFer(
//                $totals->getFer()
//                + $nutrition->getFer() * $qty
//            );
//            $totals->setCuivre(
//                $totals->getCuivre()
//                + $nutrition->getCuivre() * $qty
//            );
//            $totals->setZinc(
//                $totals->getZinc()
//                + $nutrition->getZinc() * $qty
//            );
//            $totals->setSelenium(
//                $totals->getSelenium()
//                + $nutrition->getSelenium() * $qty
//            );
//            $totals->setIode(
//                $totals->getIode()
//                + $nutrition->getIode() * $qty
//            );
//
//            // Macronutrients
//            $totals->setProteines(
//                $totals->getProteines()
//                + $nutrition->getProteines() * $qty
//            );
//            $totals->setGlucides(
//                $totals->getGlucides()
//                + $nutrition->getGlucides() * $qty
//            );
//            $totals->setLipides(
//                $totals->getLipides()
//                + $nutrition->getLipides() * $qty
//            );
//            $totals->setSucres(
//                $totals->getSucres()
//                + $nutrition->getSucres() * $qty
//            );
//            $totals->setAmidon(
//                $totals->getAmidon()
//                + $nutrition->getAmidon() * $qty
//            );
//            $totals->setFibres(
//                $totals->getFibres()
//                + $nutrition->getFibres() * $qty
//            );
//
//            // Fatty acids
//            $totals->setAgs(
//                $totals->getAgs()
//                + $nutrition->getAgs() * $qty
//            );
//            $totals->setAgmi(
//                $totals->getAgmi()
//                + $nutrition->getAgmi() * $qty
//            );
//            $totals->setAgpi(
//                $totals->getAgpi()
//                + $nutrition->getAgpi() * $qty
//            );
//
//            // Misc
//            $totals->setCholesterol(
//                $totals->getCholesterol()
//                + $nutrition->getCholesterol() * $qty
//            );
//        }
//
//        return $totals;
//    }
//
//    public function getNutritionalsPerServing(Recipe $recipe): IngredientNutrition
//    {
//        $perServing = $this->getTotalNutritionals($recipe);
//        $divisor = max(1, $recipe->getServings());
//
//        $perServing->setNrjKj($perServing->getNrjKj() / $divisor);
//        $perServing->setNrjKcal($perServing->getNrjKcal() / $divisor);
//
//        $perServing->setEau($perServing->getEau() / $divisor);
//        $perServing->setSel($perServing->getSel() / $divisor);
//        $perServing->setSodium($perServing->getSodium() / $divisor);
//        $perServing->setMagnesium($perServing->getMagnesium() / $divisor);
//        $perServing->setPhosphore($perServing->getPhosphore() / $divisor);
//        $perServing->setPotassium($perServing->getPotassium() / $divisor);
//        $perServing->setCalcium($perServing->getCalcium() / $divisor);
//        $perServing->setManganese($perServing->getManganese() / $divisor);
//        $perServing->setFer($perServing->getFer() / $divisor);
//        $perServing->setCuivre($perServing->getCuivre() / $divisor);
//        $perServing->setZinc($perServing->getZinc() / $divisor);
//        $perServing->setSelenium($perServing->getSelenium() / $divisor);
//        $perServing->setIode($perServing->getIode() / $divisor);
//
//        $perServing->setProteines($perServing->getProteines() / $divisor);
//        $perServing->setGlucides($perServing->getGlucides() / $divisor);
//        $perServing->setLipides($perServing->getLipides() / $divisor);
//        $perServing->setSucres($perServing->getSucres() / $divisor);
//        $perServing->setAmidon($perServing->getAmidon() / $divisor);
//        $perServing->setFibres($perServing->getFibres() / $divisor);
//
//        $perServing->setAgs($perServing->getAgs() / $divisor);
//        $perServing->setAgmi($perServing->getAgmi() / $divisor);
//        $perServing->setAgpi($perServing->getAgpi() / $divisor);
//
//        $perServing->setCholesterol($perServing->getCholesterol() / $divisor);
//
//        return $perServing;
//    }
// }
