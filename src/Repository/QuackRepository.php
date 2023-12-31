<?php

namespace App\Repository;

use App\Entity\Quack;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Quack>
 *
 * @method Quack|null find($id, $lockMode = null, $lockVersion = null)
 * @method Quack|null findOneBy(array $criteria, array $orderBy = null)
 * @method Quack[]    findAll()
 * @method Quack[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuackRepository extends ServiceEntityRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Quack::class);
    }

    /**
     * @return Quack[] Returns an array of Quack objects
     */
    public function findByMotherQuackId(int $value): array
    {
        /*$entityManager = $this->getEntityManager();*/
        /*
        $query = $entityManager->createQuery(
            'SELECT * FROM App\Entity\Quack q WHERE q.motherquack_id_id = :value'
        );
        $query->setParameter('value', $value);
        $query->setQuery();
        $query->getResult();
        */
        if ($value == null) {
            return [];
        } else {
            return $this->createQueryBuilder('q')
                ->where('q.motherquack_id IS NOT NULL')
                ->andWhere('q.motherquack_id = :val')
                ->setParameter('val', $value)
                ->getQuery()
                ->getResult();
        }
    }

    public function findMotherQuack($value): ?Quack
    {
        return $this->createQueryBuilder('q')
            ->where('q.motherquack_id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult();
    }

    public function deleteQuack($value)
    {
/*        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'DELETE FROM App\Entity\Quack q WHERE q.id = :value'
        );
        $query->setParameter('value', $value);
        return $query->getQuery()
            ->getResult();*/

        return $this->createQueryBuilder('q')
            ->delete()
            ->where('q.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult();
    }

    public function deleteQuackChildren($value)
    {
        if ($value == null) {
            return [];
        } else {
            return $this->createQueryBuilder('q')
                ->delete()
                ->where('q.motherquack_id = :val')
                ->setParameter('val', $value)
                ->getQuery()
                ->getResult();
        }
    }
}
