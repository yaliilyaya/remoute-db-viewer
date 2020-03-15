<?php


namespace App\Service;


use App\Entity\Table;
use App\Factory\DynamicDataBaseConnectionFactory;
use Doctrine\DBAL\DBALException;

class DynamicTableInfoService
{
    /**
     * @var DynamicDataBaseConnectionFactory
     */
    private $dynamicDataBaseConnectionFactory;

    public function __construct(DynamicDataBaseConnectionFactory $dynamicDataBaseConnectionFactory)
    {
        $this->dynamicDataBaseConnectionFactory = $dynamicDataBaseConnectionFactory;
    }

    public function getTableInfo($db, $tableName)
    {
        try {
            $connection = $this->dynamicDataBaseConnectionFactory->createConnection($db);
        } catch (DBALException $e) {
            return null;
        }
        $schemaManager = $connection->getSchemaManager();

        $table = new Table();

        $table->setConnection($connection)
            ->setTableInfo($schemaManager->listTableDetails($tableName));

        return $table;
    }
}