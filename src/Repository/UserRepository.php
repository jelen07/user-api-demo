<?php

namespace App\Repository;

use App\Entity\User;
use App\Exception\InvalidArgumentException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @return int
     */
    public function getTotalCount(): int
    {
        return $this->createQueryBuilder('u')
            ->select('COUNT(u.id) as count')
            ->getQuery()
            ->getResult()[0]['count']
        ;
    }

    /**
     * @param int $page
     * @param int $size
     *
     * @return Paginator
     */
    public function getPaginator(int $page = 1, int $size = 10): Paginator
    {
        if ($page <= 0) {
            throw new InvalidArgumentException('The \'page\' parameter must be a positive integer.');
        }
        if ($size <= 0) {
            throw new InvalidArgumentException('The \'size\' parameter must be a positive integer.');
        }

        $dql = 'SELECT u FROM App\Entity\User u ORDER BY u.id';
        $query = $this->getEntityManager()->createQuery($dql)
            ->setFirstResult(($page - 1) * $size)
            ->setMaxResults($size);

        return new Paginator($query);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('u')
            ->where('u.something = :value')->setParameter('value', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
