<?php


namespace App\Factory;

use Doctrine\DBAL\DriverManager;

class DynamicDataBaseConnectionFactory
{
    /**
     * @param string $alias alias or full connection
     * TODO:: alias
     * @return \Doctrine\DBAL\Connection
     * @throws \Doctrine\DBAL\DBALException
     */
    public function createConnection($alias)
    {
        $params = [
            'url' => 'mysql://***:***@***:3306/***'
        ];

        return DriverManager::getConnection($params);
    }
}