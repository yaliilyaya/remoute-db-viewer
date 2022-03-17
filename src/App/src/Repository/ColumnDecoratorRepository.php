<?php


namespace App\Repository;

use App\Entity\ColumnDecorator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class TableRepository
 * @package App\Repository
 * @method ColumnDecorator find($id, $lockMode = null, $lockVersion = null)
 * @method ColumnDecorator findOneBy(array $criteria, array $orderBy = null)
 * @method ColumnDecorator[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ColumnDecoratorRepository extends ServiceEntityRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, ManagerRegistry $registry)
    {
        parent::__construct($registry, ColumnDecorator::class);
        $this->entityManager = $entityManager;
    }

    /**
     * @param ColumnDecorator $Table
     */
    public function save($Table)
    {
        $this->entityManager->persist($Table);
        $this->entityManager->flush();
    }

    public function remove(ColumnDecorator $Table)
    {
        $this->entityManager->remove($Table);
        $this->entityManager->flush();
    }
}