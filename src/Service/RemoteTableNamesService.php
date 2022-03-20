<?php


namespace App\Service;


use App\Factory\ConnectionFactory;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;

class RemoteTableNamesService
{
    public function getNames(Connection $connection)
    {
        $schemaManager = $connection->getSchemaManager();
        return $schemaManager->listTableNames();
    }
}