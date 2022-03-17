<?php


namespace App\Factory;


use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;

interface ConnectionFactoryInterface
{
    /**
     * @param string $db alias or full connection
     * @return Connection
     * @throws DBALException
     */
    public function createConnection($db) :Connection;

}