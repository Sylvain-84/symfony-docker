<?php

declare(strict_types=1);

namespace App\Enum;

enum DifficultyEnum: string
{
    case VERY_EASY = 'very_easy';
    case EASY = 'easy';
    case MEDIUM = 'medium';
    case HARD = 'hard';
}
