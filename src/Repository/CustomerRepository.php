<?php

namespace App\Repository;

use App\Entity\Customer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Customer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Customer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Customer[]    findAll()
 * @method Customer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerRepository extends ServiceEntityRepository
{


    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Customer::class);
    }


    public function countCards()
    {
        return $this->createQueryBuilder('b')
        ->where('b.loyalty_card IS NOT NULL ')
        ->select('count(b.loyalty_card)')
        ->getQuery()
        ->getSingleScalarResult();
    }


}
