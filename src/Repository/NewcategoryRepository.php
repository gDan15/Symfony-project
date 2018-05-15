<?php

namespace App\Repository;

use App\Entity\Newcategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Newcategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method Newcategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method Newcategory[]    findAll()
 * @method Newcategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewcategoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Newcategory::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('n')
            ->where('n.something = :value')->setParameter('value', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
