<?php

declare(strict_types=1);

namespace App\Dto\Ingredient;

use App\Entity\Ingredient\IngredientMinerals;

final readonly class IngredientMineralsDto
{
    public function __construct(
        public ?float $calcium,
        public ?float $cuivre,
        public ?float $fer,
        public ?float $iode,
        public ?float $magnesium,
        public ?float $manganese,
        public ?float $phosphore,
        public ?float $potassium,
        public ?float $selenium,
        public ?float $sodium,
        public ?float $zinc,
    ) {
    }

    public static function transform(IngredientMinerals $minerals): self
    {
        return new self(
            calcium: $minerals->getCalcium(),
            cuivre: $minerals->getCuivre(),
            fer: $minerals->getFer(),
            iode: $minerals->getIode(),
            magnesium: $minerals->getMagnesium(),
            manganese: $minerals->getManganese(),
            phosphore: $minerals->getPhosphore(),
            potassium: $minerals->getPotassium(),
            selenium: $minerals->getSelenium(),
            sodium: $minerals->getSodium(),
            zinc: $minerals->getZinc(),
        );
    }
}
