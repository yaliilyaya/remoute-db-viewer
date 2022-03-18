<?php


namespace App\Service;

use App\Builder\ColumnCollectionByTableBuilder;
use App\Entity\TableInfo;
use App\Factory\ConnectionFactory;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;

class RemoteTableInfoService
{
    /**
     * @var ColumnCollectionByTableBuilder
     */
    private $columnCollectionByTableBuilder;

    public function __construct(
        ColumnCollectionByTableBuilder $columnCollectionByTableBuilder
    ) {
        $this->columnCollectionByTableBuilder = $columnCollectionByTableBuilder;
    }

    /**
     * @param Connection $connection
     * @param $tableName
     * @return TableInfo
     * @throws DBALException
     */
    public function getTableInfo(Connection $connection, $tableName): TableInfo
    {
        $schemaManager = $connection->getSchemaManager();

        $table = new TableInfo();

        $table->setConnection($connection)
            ->setTableInfo($schemaManager->listTableDetails($tableName));

        if (!$table->getColumns()->count())
        {
            $columns = $this->columnCollectionByTableBuilder->create($table);
            $columns->setTable($table);
            $table->setColumns($columns);
        }

        return $table;
    }
}