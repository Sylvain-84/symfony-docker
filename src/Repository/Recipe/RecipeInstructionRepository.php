<?php

declare(strict_types=1);

namespace App\Repository\Recipe;

use App\Entity\Recipe\RecipeInstruction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RecipeInstruction>
 */
class RecipeInstructionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecipeInstruction::class);
    }
}
