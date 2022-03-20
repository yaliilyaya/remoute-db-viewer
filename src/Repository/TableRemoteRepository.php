<?php


namespace App\Repository;

use App\Builder\DelayedConnectionBuilder;
use App\Entity\DataBaseInfo;
use App\Entity\TableInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Table;

class TableRemoteRepository
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param DataBaseInfo $dataBase
     * @return array
     */
    public function findAll(DataBaseInfo $dataBase)
    {
        $tableNames = $this->findAllNames();

        return array_map(function ($tableName) use ($dataBase)
        {
            $table = $this->getTableInfo($tableName);
            $tableInfo =  new TableInfo();
            $tableInfo->setTableInfo($table);
            $tableInfo->setIsActive((bool)$table);

            $tableInfo->setName($tableName)
                ->setLabel($tableName)
                ->setDatabase($dataBase);
            return $table;
        }, $tableNames);
    }

    /**
     * @param $tableName
     * @return Table
     */
    public function getTableInfo($tableName): Table
    {
        $schemaManager = $this->connection->getSchemaManager();
        return $schemaManager->listTableDetails($tableName);
    }

    /**
     * @return string[]
     */
    public function findAllNames(): array
    {
        $schemaManager = $this->connection->getSchemaManager();
        return $schemaManager->listTableNames();
    }
}