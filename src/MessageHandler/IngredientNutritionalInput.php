<?php

namespace App\MessageHandler;

final readonly class IngredientNutritionalInput
{
    public function __construct(
        public ?float $kilocalories = 0,
        public ?float $proteine = 0,
        public ?float $glucides = 0,
        public ?float $lipides = 0,
        public ?float $sucres = null,
        public ?float $amidon = null,
        public ?float $fibresAlimentaires = null,
        public ?float $cholesterol = null,
        public ?float $acidesGrasSatures = null,
        public ?float $acidesGrasMonoinsatures = null,
        public ?float $acidesGrasPolyinsatures = null,
        public ?float $eau = null
    ) {}
}
