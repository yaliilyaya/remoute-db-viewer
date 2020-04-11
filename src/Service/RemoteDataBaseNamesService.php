<?php

namespace App\Service;


use App\Factory\ConnectionFactory;
use Doctrine\DBAL\Connection;

class RemoteDataBaseNamesService
{
    /**
     * @var ConnectionFactory
     */
    private $dynamicDataBaseConnectionFactory;

    public function __construct(ConnectionFactory $dynamicDataBaseConnectionFactory)
    {
        $this->dynamicDataBaseConnectionFactory = $dynamicDataBaseConnectionFactory;
    }

    public function getNames(Connection $connection)
    {
        $schemaManager = $connection->getSchemaManager();
        return $schemaManager->listDatabases();
    }




}