<?php


namespace App\Repository;

use App\Entity\RemoteTableColumn;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class TableRepository
 * @package App\Repository
 * @method RemoteTableColumn find($id, $lockMode = null, $lockVersion = null)
 * @method RemoteTableColumn findOneBy(array $criteria, array $orderBy = null)
 * @method RemoteTableColumn[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RemoteTableColumnRepository extends ServiceEntityRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, ManagerRegistry $registry)
    {
        parent::__construct($registry, RemoteTableColumn::class);
        $this->entityManager = $entityManager;
    }

    /**
     * @param RemoteTableColumn $Table
     */
    public function save($Table)
    {
        $this->entityManager->persist($Table);
        $this->entityManager->flush();
    }

    public function remove(RemoteTableColumn $Table)
    {
        $this->entityManager->remove($Table);
        $this->entityManager->flush();
    }
}