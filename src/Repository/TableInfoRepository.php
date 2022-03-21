<?php


namespace App\Repository;

use App\Builder\DelayedConnectionBuilder;
use App\Entity\TableInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class TableRepository
 * @package App\Repository
 * @method TableInfo find($id, $lockMode = null, $lockVersion = null)
 * @method TableInfo findOneBy(array $criteria, array $orderBy = null)
 * @method TableInfo[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TableInfoRepository extends ServiceEntityRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var DataBaseInfoRepository
     */
    private $baseRepository;

    public function __construct(
        EntityManagerInterface   $entityManager,
        ManagerRegistry          $registry,
        DataBaseInfoRepository   $dataBaseRepository
    ) {
        parent::__construct($registry, TableInfo::class);
        $this->entityManager = $entityManager;
        $this->baseRepository = $dataBaseRepository;
    }

    /**
     * @param TableInfo $table
     */
    public function save(TableInfo $table): void
    {
        $this->entityManager->persist($table);
        $this->entityManager->flush();
    }

    /**
     * @param TableInfo $Table
     */
    public function remove(TableInfo $Table): void
    {
        $this->entityManager->remove($Table);
        $this->entityManager->flush();
    }

    public function saveAll(array $tables)
    {
        array_walk($tables, [$this->entityManager, 'persist']);
        $this->entityManager->flush();
    }

    /**
     * @param $dbAlias
     * @param $tableName
     * @return TableInfo
     */
    public function findByTableFullName($dbAlias, $tableName): ?TableInfo
    {
        $db = $this->baseRepository->findOneBy(['alias' => $dbAlias]);

        return $this->findOneBy([
            'name' => $tableName,
            'dataBase' => $db
        ]);
    }

}