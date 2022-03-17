<?php


namespace App\Service;


use App\Factory\ConnectionFactory;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;

class RemoteTableNamesService
{
    /**
     * @var ConnectionFactory
     */
    private $connectionFactory;

    public function __construct(ConnectionFactory $connectionFactory)
    {
        $this->connectionFactory = $connectionFactory;
    }

    public function getNames(Connection $connection)
    {
        $schemaManager = $connection->getSchemaManager();
        return $schemaManager->listTableNames();
    }
}