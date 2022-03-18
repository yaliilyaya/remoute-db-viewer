<?php


namespace App\Factory;

use App\Entity\DataBaseInfo;
use App\Repository\DataBaseRepository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\DriverManager;

class ConnectionByDataBaseFactory
{
    /**
     * @var DataBaseRepository
     */
    private $baseRepository;

    public function __construct(DataBaseRepository $baseRepository)
    {
        $this->baseRepository = $baseRepository;
    }

    /**
     * @param DataBaseInfo $dataBase
     * @return Connection
     * @throws DBALException
     */
    public function createConnection(DataBaseInfo $dataBase)
    {
        $params = [
            'url' => $dataBase->getConnectionUrl()
        ];

        return DriverManager::getConnection($params);
    }
}