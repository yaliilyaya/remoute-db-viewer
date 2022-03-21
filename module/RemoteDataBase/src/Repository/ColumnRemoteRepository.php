<?php


namespace RemoteDataBase\Repository;

use Doctrine\DBAL\Connection;

/**
 * Class TableRepository
 * @package App\Repository
 */
class ColumnRemoteRepository
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }
}