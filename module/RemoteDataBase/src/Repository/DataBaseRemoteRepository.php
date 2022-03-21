<?php

namespace RemoteDataBase\Repository;

use Doctrine\DBAL\Connection;

/**
 * Class TableRepository
 * @package App\Repository
 */
class DataBaseRemoteRepository
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
     * @return string[]
     */
    public function findNames(): array
    {
        $schemaManager = $this->connection->getSchemaManager();
        return $schemaManager->listDatabases();
    }
}