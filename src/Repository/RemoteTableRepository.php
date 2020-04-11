<?php


namespace App\Repository;

use App\Entity\RemoteTable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class TableRepository
 * @package App\Repository
 * @method RemoteTable findOneBy(array $criteria, array $orderBy = null)
 * @method RemoteTable[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RemoteTableRepository extends ServiceEntityRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, ManagerRegistry $registry)
    {
        parent::__construct($registry, RemoteTable::class);
        $this->entityManager = $entityManager;
    }

    /**
     * @param RemoteTable $Table
     */
    public function save($Table)
    {
        $this->entityManager->persist($Table);
        $this->entityManager->flush();
    }

    public function remove(RemoteTable $Table)
    {
        $this->entityManager->remove($Table);
        $this->entityManager->flush();
    }
}