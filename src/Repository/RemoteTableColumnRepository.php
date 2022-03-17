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

    /**
     * @param RemoteTableColumn $Table
     */
    public function remove(RemoteTableColumn $Table): void
    {
        $this->entityManager->remove($Table);
        $this->entityManager->flush();
    }

    /**
     * @param $tableId
     * @return array
     */
    public function findIdsByTable($tableId): array
    {
        $queryBuilder = $this->createQueryBuilder('column');

        $query = $this->createQueryBuilder('column')
            ->where($queryBuilder->expr()->eq('column.table', $tableId))
            ->select(['column.id'])
            ->getQuery();

        return array_map('current', $query->getArrayResult());
    }
}