<?php

namespace App\Service;

use App\Builder\ColumnCollectionByTableBuilder;
use App\Entity\RemoteTable;
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
     * @throws DBALException
     */
    public function sync(Connection $connection, RemoteTable $table): void
    {
        $schemaManager = $connection->getSchemaManager();

        $table->setConnection($connection)
            ->setTableInfo($schemaManager->listTableDetails($table->getName()));

        $columns = $this->columnCollectionByTableBuilder->create($table);
        $columns->setTable($table);
        $table->setColumns($columns);

        $this->saveTable($table);
    }

    /**
     * @param RemoteTable $table
     */
    private function saveTable(RemoteTable $table): void
    {
        $this->entityManager->persist($table);
        $this->entityManager->flush();
    }

}