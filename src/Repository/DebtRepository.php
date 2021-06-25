<?php

namespace App\Repository;

use App\Entity\Debt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Debt|null find($id, $lockMode = null, $lockVersion = null)
 * @method Debt|null findOneBy(array $criteria, array $orderBy = null)
 * @method Debt[]    findAll()
 * @method Debt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DebtRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Debt::class);
    }

    public function search($value): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT d.*, u.firstname, u.lastname  
                FROM debt as d 
                LEFT JOIN users as u 
                ON d.user_id = u.id 
                WHERE u.firstname LIKE :keyword 
                OR u.lastname LIKE :keyword 
                AND d.view_status = 5 
                GROUP BY u.id  
                ORDER BY d.created_at DESC";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['keyword' => '%'.$value.'%']);

        return $stmt->fetchAll();
    }

    public function getDebt(int $id): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT * FROM debt WHERE user_id = :user AND view_status = 5 ORDER BY created_at DESC";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['user' => $id]);

        return $stmt->fetchAll();
    }

    // /**
    //  * @return Debt[] Returns an array of Debt objects
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
    public function findOneBySomeField($value): ?Debt
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
