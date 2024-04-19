<?php

namespace App\Repository;

use App\Entity\Responses;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Responses>
 *
 * @method Responses|null find($id, $lockMode = null, $lockVersion = null)
 * @method Responses|null findOneBy(array $criteria, array $orderBy = null)
 * @method Responses[]    findAll()
 * @method Responses[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResponsesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Responses::class);
    }

    /**
     * @return array<string, mixed> | boolean
     */
    public function getVoteByResponse(int $userId, int $responseId): array | bool
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql =
            "SELECT v.vote,v.id
            FROM votes v
            JOIN users u ON
            v.user_id = u.id
            JOIN responses r ON
            v.responses_id = r.id
            WHERE u.id = :userId AND r.id = :responseId";

        $resultSet = $conn->executeQuery($sql, [
            'userId' => $userId,
            'responseId' => $responseId
        ]);
        return $resultSet->fetchAssociative();
    }


    public function getVoteTrue(int $responseId): int
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql =
            "SELECT count(v.vote)
            FROM votes v 
            JOIN responses r ON
            v.responses_id = r.id
            WHERE v.vote = true AND r.id = :responseId";

        $resultSet = $conn->executeQuery($sql, [
            'responseId' => $responseId
        ]);
        return $resultSet->fetchOne();
    }

    public function getvote(int $userId, int $responseId): bool
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql =
            "SELECT v.vote
        FROM votes v
        JOIN users u ON
        v.user_id = u.id
        JOIN responses r ON
        v.response_id = r.id
        WHERE u.id = :userId AND r.id = :responseId";

        $resultSet = $conn->executeQuery($sql, [
            'responseId' => $responseId,
            'userId' => $userId
        ]);
        return $resultSet->fetchOne();
    }

    //    /**
    //     * @return Responses[] Returns an array of Responses objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Responses
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}