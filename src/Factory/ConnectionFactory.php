<?php


namespace App\Factory;

use App\Repository\DataBaseRepository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\DriverManager;
use Exception;

class ConnectionFactory
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
     * @param string $alias alias or full connection
     * @return Connection
     * @throws DBALException
     * @throws Exception
     */
    public function createConnection($alias)
    {
        $dataBase = $this->baseRepository->findByAlias($alias);
        if (!$dataBase)
        {
            throw new Exception('Not found connection - ' . $alias );
        }

        $params = [
            'url' => $dataBase->getConnectionUrl()
        ];

        return DriverManager::getConnection($params);
    }
}