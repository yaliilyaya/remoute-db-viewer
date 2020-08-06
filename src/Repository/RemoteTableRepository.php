<?php


namespace App\Repository;

use App\Builder\DelayedConnectionBuilder;
use App\Entity\RemoteTable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class TableRepository
 * @package App\Repository
 * @method RemoteTable find($id, $lockMode = null, $lockVersion = null)
 * @method RemoteTable findOneBy(array $criteria, array $orderBy = null)
 * @method RemoteTable[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
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
        parent::__construct($registry, RemoteTable::class);
        $this->entityManager = $entityManager;
        $this->baseRepository = $dataBaseRepository;
        $this->delayedConnectionBuilder = $delayedConnectionBuilder;
    }

    /**
     * @param RemoteTable $Table
     */
    public function save($Table): void
    {
        $this->entityManager->persist($Table);
        $this->entityManager->flush();
    }

    /**
     * @param RemoteTable $Table
     */
    public function remove(RemoteTable $Table): void
    {
        $this->entityManager->remove($Table);
        $this->entityManager->flush();
    }

    /**
     * @param $dbAlias
     * @param $tableName
     * @return RemoteTable
     */
    public function findByTableFullName($dbAlias, $tableName): ?RemoteTable
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