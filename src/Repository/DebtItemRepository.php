<?php

namespace App\Repository;

use App\Entity\DebtItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DebtItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method DebtItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method DebtItem[]    findAll()
 * @method DebtItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DebtItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DebtItem::class);
    }

    public function getDebtItems(int $id): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT * FROM debt_item WHERE debt_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->fetchAll();
    }

    // /**
    //  * @return DebtItem[] Returns an array of DebtItem objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DebtItem
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
