<?php


namespace App\Factory;

use App\Entity\RemoteDataBase;
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
     * @param RemoteDataBase $dataBase
     * @return Connection
     * @throws DBALException
     */
    public function createConnection(RemoteDataBase $dataBase)
    {
        $params = [
            'url' => $dataBase->getConnectionUrl()
        ];

        return DriverManager::getConnection($params);
    }
}