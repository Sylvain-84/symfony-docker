<?php

declare(strict_types=1);

namespace App\Dto\Ingredient;

use App\Entity\Ingredient\IngredientVitamines;

final readonly class IngredientVitaminesDto
{
    public function __construct(
        public ?float $vitamineA,
        public ?float $betaCarotene,
        public ?float $vitamineD,
        public ?float $vitamineE,
        public ?float $vitamineK1,
        public ?float $vitamineK2,
        public ?float $vitamineC,
        public ?float $vitamineB1,
        public ?float $vitamineB2,
        public ?float $vitamineB3,
        public ?float $vitamineB5,
        public ?float $vitamineB6,
        public ?float $vitamineB9,
        public ?float $vitamineB12,
    ) {
    }

    public static function transform(IngredientVitamines $vitamines): self
    {
        return new self(
            vitamineA: $vitamines->getVitamineA(),
            betaCarotene: $vitamines->getBetaCarotene(),
            vitamineD: $vitamines->getVitamineD(),
            vitamineE: $vitamines->getVitamineE(),
            vitamineK1: $vitamines->getVitamineK1(),
            vitamineK2: $vitamines->getVitamineK2(),
            vitamineC: $vitamines->getVitamineC(),
            vitamineB1: $vitamines->getVitamineB1(),
            vitamineB2: $vitamines->getVitamineB2(),
            vitamineB3: $vitamines->getVitamineB3(),
            vitamineB5: $vitamines->getVitamineB5(),
            vitamineB6: $vitamines->getVitamineB6(),
            vitamineB9: $vitamines->getVitamineB9(),
            vitamineB12: $vitamines->getVitamineB12(),
        );
    }
}
