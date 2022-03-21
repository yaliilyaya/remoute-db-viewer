<?php


namespace RemoteDataBase\Factory;

use App\Entity\DataBaseInfo;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;
use RemoteDataBase\Exception\ConnectionException;

class ConnectionBuilder
{
    /**
     * @param DataBaseInfo $dataBase
     * @return Connection
     * @throws ConnectionException
     */
    public function createConnection(DataBaseInfo $dataBase): Connection
    {
        $params = [
            'url' => $dataBase->getConnectionUrl()
        ];

        try {
            return DriverManager::getConnection($params);
        } catch (Exception $e) {
            throw new ConnectionException(
                $e->getMessage(),
                $e->getCode()
            );
        }
    }
}