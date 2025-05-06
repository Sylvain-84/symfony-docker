<?php

declare(strict_types=1);

namespace App\Repository\Ingredient;

use App\Entity\Ingredient\Ingredient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ingredient>
 */
class IngredientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ingredient::class);
    }

    /**
     * @return Ingredient[] Returns an array of Ingredient objects
     */
    public function findAllOrderedByName(): array
    {
        return $this->createQueryBuilder('i')
            ->orderBy('UNACCENT(LOWER(i.name))', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function save(Ingredient $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Ingredient $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
