<?php

declare(strict_types=1);

namespace App\Dto\Ingredient;

use App\Entity\Ingredient\IngredientNutritionals;

final readonly class IngredientNutritionalsDto
{
    public function __construct(
        public float $kilocalories,
        public float $proteine,
        public float $glucides,
        public float $lipides,
        public ?float $sucres,
        public ?float $amidon,
        public ?float $fibresAlimentaires,
        public ?float $cholesterol,
        public ?float $acidesGrasSatures,
        public ?float $acidesGrasMonoinsatures,
        public ?float $acidesGrasPolyinsatures,
        public ?float $eau,
    ) {
    }

    public static function transform(IngredientNutritionals $nutritionals): self
    {
        return new self(
            kilocalories: $nutritionals->getKilocalories(),
            proteine: $nutritionals->getProteine(),
            glucides: $nutritionals->getGlucides(),
            lipides: $nutritionals->getLipides(),
            sucres: $nutritionals->getSucres(),
            amidon: $nutritionals->getAmidon(),
            fibresAlimentaires: $nutritionals->getFibresAlimentaires(),
            cholesterol: $nutritionals->getCholesterol(),
            acidesGrasSatures: $nutritionals->getAcidesGrasSatures(),
            acidesGrasMonoinsatures: $nutritionals->getAcidesGrasMonoinsatures(),
            acidesGrasPolyinsatures: $nutritionals->getAcidesGrasPolyinsatures(),
            eau: $nutritionals->getEau(),
        );
    }
}
