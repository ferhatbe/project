<?php

namespace App\Repository;

use App\Entity\Colis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Colis|null find($id, $lockMode = null, $lockVersion = null)
 * @method Colis|null findOneBy(array $criteria, array $orderBy = null)
 * @method Colis[]    findAll()
 * @method Colis[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ColisRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Colis::class);
    }


    // recuperation de mes colis
    public function findMyListColis($loUser)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.user = :user')
            ->setParameter('user', $loUser)
            ->getQuery()
            ->getResult();
    }



    public function findAllAdvertisement($allAdvertisement)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.user != :advert')
            ->setParameter('advert', $allAdvertisement)
            ->getQuery()
            ->getResult()
        ;
    }

}
