<?php


namespace App\Service;


use App\Factory\DynamicDataBaseConnectionFactory;
use Doctrine\DBAL\DBALException;

class DynamicTableNamesService
{
    /**
     * @var DynamicDataBaseConnectionFactory
     */
    private $dynamicDataBaseConnectionFactory;

    public function __construct(DynamicDataBaseConnectionFactory $dynamicDataBaseConnectionFactory)
    {
        $this->dynamicDataBaseConnectionFactory = $dynamicDataBaseConnectionFactory;
    }

    public function getNames($db)
    {
        try
        {
            $connection = $this->dynamicDataBaseConnectionFactory->createConnection($db);
        }
        catch (DBALException $e)
        {
            return [];
        }

        $schemaManager = $connection->getSchemaManager();
        return $schemaManager->listTableNames();
    }
}