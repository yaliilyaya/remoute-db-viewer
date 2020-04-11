<?php


namespace App\Service;


use App\Builder\ColumnCollectionByTableBuilder;
use App\Entity\RemoteTable;
use App\Factory\ConnectionFactory;
use Doctrine\DBAL\DBALException;

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

    public function getTableInfo($db, $tableName)
    {
        try {
            $connection = $this->dynamicDataBaseConnectionFactory->createConnection($db);
        } catch (DBALException $e) {
            return null;
        }
        $schemaManager = $connection->getSchemaManager();

        $table = new RemoteTable();

        $table->setConnection($connection)
            ->setTableInfo($schemaManager->listTableDetails($tableName));

        if (!$table->getColumns()->count())
        {
            $columns = $this->columnCollectionByTableBuilder->create($table);
            $table->setColumns($columns);
        }

        return $table;
    }
}