<?php

declare(strict_types=1);

namespace App\MessageHandler\Ingredient;

final readonly class IngredientVitamineInput
{
    public function __construct(
        public ?float $vitamineA = null,
        public ?float $betaCarotene = null,
        public ?float $vitamineD = null,
        public ?float $vitamineE = null,
        public ?float $vitamineK1 = null,
        public ?float $vitamineK2 = null,
        public ?float $vitamineC = null,
        public ?float $vitamineB1 = null,
        public ?float $vitamineB2 = null,
        public ?float $vitamineB3 = null,
        public ?float $vitamineB5 = null,
        public ?float $vitamineB6 = null,
        public ?float $vitamineB9 = null,
        public ?float $vitamineB12 = null,
    ) {
    }
}
