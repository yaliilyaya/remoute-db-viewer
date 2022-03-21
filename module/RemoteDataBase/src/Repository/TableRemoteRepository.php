<?php


namespace RemoteDataBase\Repository;

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
     * @return Table[]
     */
    public function findAll(): array
    {
        $tableNames = $this->findAllNames();

        $tables = array_map([$this, 'getTableInfo'], $tableNames);
        return array_filter($tables);
    }

    /**
     * @param $tableName
     * @return Table|null
     */
    public function getTableInfo($tableName): ?Table
    {
        $schemaManager = $this->connection->getSchemaManager();
        try {
            return $schemaManager->listTableDetails($tableName);
        } catch (\Exception $exception) {
            return null;
        }
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