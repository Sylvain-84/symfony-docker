<?php

namespace App\MessageHandler\Ingredient;

final readonly class IngredientMineralInput
{
    public function __construct(
        public ?float $calcium = null,
        public ?float $cuivre = null,
        public ?float $fer = null,
        public ?float $iode = null,
        public ?float $magnesium = null,
        public ?float $manganese = null,
        public ?float $phosphore = null,
        public ?float $potassium = null,
        public ?float $selenium = null,
        public ?float $sodium = null,
        public ?float $zinc = null
    ) {}
}
