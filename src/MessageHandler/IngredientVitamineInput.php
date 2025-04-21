<?php

namespace App\MessageHandler;

final readonly class IngredientVitamineInput
{
    public function __construct(
        public ?string $vitamineA = null,
        public ?string $betaCarotene = null,
        public ?string $vitamineD = null,
        public ?string $vitamineE = null,
        public ?string $vitamineK1 = null,
        public ?string $vitamineK2 = null,
        public ?string $vitamineC = null,
        public ?string $vitamineB1 = null,
        public ?string $vitamineB2 = null,
        public ?string $vitamineB3 = null,
        public ?string $vitamineB5 = null,
        public ?string $vitamineB6 = null,
        public ?string $vitamineB9 = null,
        public ?string $vitamineB12 = null
    ) {}
}
