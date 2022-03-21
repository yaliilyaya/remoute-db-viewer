<?php


namespace App\Repository;

use App\Entity\ColumnInfo;
use App\Entity\TableInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class TableRepository
 * @package App\Repository
 * @method ColumnInfo find($id, $lockMode = null, $lockVersion = null)
 * @method ColumnInfo findOneBy(array $criteria, array $orderBy = null)
 * @method ColumnInfo[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ColumnInfoRepository extends ServiceEntityRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, ManagerRegistry $registry)
    {
        parent::__construct($registry, ColumnInfo::class);
        $this->entityManager = $entityManager;
    }

    /**
     * @param ColumnInfo $table
     */
    public function save(ColumnInfo $table)
    {
        $this->entityManager->persist($table);
        $this->entityManager->flush();
    }

    /**
     * @param ColumnInfo $table
     */
    public function remove(ColumnInfo $table): void
    {
        $this->entityManager->remove($table);
        $this->entityManager->flush();
    }

    /**
     * @param TableInfo $tableInfo
     * @return void
     */
    public function removeByTable(TableInfo $tableInfo): void
    {
        $columns = iterator_to_array($tableInfo->getColumns());
        array_walk($columns, [$this->entityManager, 'remove']);
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