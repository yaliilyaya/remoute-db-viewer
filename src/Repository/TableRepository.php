<?php


namespace App\Repository;

use App\Entity\Table;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class TableRepository
 * @package App\Repository
 * @method Table findOneBy(array $criteria, array $orderBy = null)
 * @method Table[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TableRepository extends ServiceEntityRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, ManagerRegistry $registry)
    {
        parent::__construct($registry, Table::class);
        $this->entityManager = $entityManager;
    }

    /**
     * @param Table $Table
     */
    public function save($Table)
    {
        $this->entityManager->persist($Table);
        $this->entityManager->flush();
    }

    public function remove(Table $Table)
    {
        $this->entityManager->remove($Table);
        $this->entityManager->flush();
    }
}