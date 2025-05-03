<?php

declare(strict_types=1);

namespace App\MessageHandler\Recipe\Recipe;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class InstructionInput
{
    public function __construct(
        #[Assert\NotBlank]
        public string $name,
        #[Assert\NotBlank]
        public string $description,
        #[Assert\Positive]
        public int $position,
    ) {
    }
}
