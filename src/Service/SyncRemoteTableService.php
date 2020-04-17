<?php

namespace App\Service;

use App\Builder\ColumnCollectionByTableBuilder;
use App\Entity\RemoteDataBase;
use App\Entity\RemoteTable;
use App\Factory\ConnectionFactory;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class SyncRemoteTableService
 * @package App\Service
 */
class SyncRemoteTableService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var ColumnCollectionByTableBuilder
     */
    private $columnCollectionByTableBuilder;

    /**
     * SyncRemoteTableService constructor.
     * @param EntityManagerInterface $entityManager
     * @param ColumnCollectionByTableBuilder $columnCollectionByTableBuilder
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        ColumnCollectionByTableBuilder $columnCollectionByTableBuilder
    ) {
        $this->entityManager = $entityManager;
        $this->columnCollectionByTableBuilder = $columnCollectionByTableBuilder;
    }

    /**
     * @param Connection $connection
     * @param RemoteTable $table
     */
    public function sync(Connection $connection, RemoteTable $table)
    {
        $schemaManager = $connection->getSchemaManager();

        $table->setConnection($connection)
            ->setTableInfo($schemaManager->listTableDetails($table->getName()));

        $columns = $this->columnCollectionByTableBuilder->create($table);
        $table->setColumns($columns);
        $this->save($columns->toArray());
    }

    private function save(array $columns)
    {
        array_walk($columns, [$this->entityManager, 'persist']);
        $this->entityManager->flush();
    }

}