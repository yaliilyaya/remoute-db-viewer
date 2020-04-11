<?php


namespace App\Service;

use App\Builder\ColumnCollectionByTableBuilder;
use App\Entity\RemoteTable;
use App\Factory\ConnectionFactory;
use Doctrine\DBAL\Connection;

class RemoteTableInfoService
{
    /**
     * @var ConnectionFactory
     */
    private $dynamicDataBaseConnectionFactory;
    /**
     * @var ColumnCollectionByTableBuilder
     */
    private $columnCollectionByTableBuilder;

    public function __construct(
        ConnectionFactory $dynamicDataBaseConnectionFactory,
        ColumnCollectionByTableBuilder $columnCollectionByTableBuilder
    ) {
        $this->dynamicDataBaseConnectionFactory = $dynamicDataBaseConnectionFactory;
        $this->columnCollectionByTableBuilder = $columnCollectionByTableBuilder;
    }

    /**
     * @param Connection $connection
     * @param $tableName
     * @return RemoteTable|null
     */
    public function getTableInfo(Connection $connection, $tableName)
    {
        $schemaManager = $connection->getSchemaManager();

        $table = new RemoteTable();

        $table->setConnection($connection)
            ->setTableInfo($schemaManager->listTableDetails($tableName));

//        if (!$table->getColumns()->count())
//        {
//            $columns = $this->columnCollectionByTableBuilder->create($table);
//            $table->setColumns($columns);
//        }

        return $table;
    }
}