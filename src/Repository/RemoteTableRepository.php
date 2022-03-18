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
class RemoteTableRepository extends ServiceEntityRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var DataBaseRepository
     */
    private $baseRepository;
    /**
     * @var DelayedConnectionBuilder
     */
    private $delayedConnectionBuilder;

    public function __construct(
        EntityManagerInterface $entityManager,
        ManagerRegistry $registry,
        DataBaseRepository $dataBaseRepository,
        DelayedConnectionBuilder $delayedConnectionBuilder
    ) {
        parent::__construct($registry, TableInfo::class);
        $this->entityManager = $entityManager;
        $this->baseRepository = $dataBaseRepository;
        $this->delayedConnectionBuilder = $delayedConnectionBuilder;
    }

    /**
     * @param TableInfo $Table
     */
    public function save($Table): void
    {
        $this->entityManager->persist($Table);
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

    /**
     * @param $dbAlias
     * @param $tableName
     * @return TableInfo
     */
    public function findByTableFullName($dbAlias, $tableName): ?TableInfo
    {
        $db = $this->baseRepository->findOneBy(['alias' => $dbAlias]);

        $table = $this->findOneBy([
            'name' => $tableName,
            'database' => $db
        ]);

        $delayedConnection = $this->delayedConnectionBuilder->create($db, $table);
        $table->setDelayedConnection($delayedConnection);

        return $table;
    }
}