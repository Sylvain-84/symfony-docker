<?php

declare(strict_types=1);

namespace App\Enum;

enum UnityEnum: string
{
    case GRAMS = 'g';
    case KILOGRAMS = 'kg';
    case LITERS = 'l';
    case MILLILITERS = 'ml';
    case CUPS = 'cup';
    case TEASPOONS = 'tsp';
    case TABLESPOONS = 'tbsp';
    case PIECES = 'pieces';
}
