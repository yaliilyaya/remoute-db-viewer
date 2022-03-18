<?php

namespace App\Service;

use App\Builder\ColumnCollectionByTableBuilder;
use App\Entity\TableInfo;
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
     * @param TableInfo $table
     * @throws DBALException
     */
    public function sync(Connection $connection, TableInfo $table): void
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
     * @param TableInfo $table
     */
    private function saveTable(TableInfo $table): void
    {
        $this->entityManager->persist($table);
        $this->entityManager->flush();
    }

}