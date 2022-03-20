<?php


namespace App\Factory;

use App\Entity\DataBaseInfo;
use App\Exception\ConnectionException;
use App\Repository\DataBaseInfoRepository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;

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