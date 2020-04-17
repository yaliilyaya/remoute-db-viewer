<?php

namespace App\Service;

use App\Builder\ColumnCollectionByTableBuilder;
use App\Entity\RemoteTable;
use Doctrine\DBAL\Connection;
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

        $this->saveTable($table);
    }

    private function saveTable(RemoteTable $table)
    {
        $this->entityManager->persist($table);
        $this->entityManager->flush();
    }

}