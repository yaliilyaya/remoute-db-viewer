<?php


namespace App\Factory;

use App\Repository\DataBaseInfoRepository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\DriverManager;
use Exception;

class ConnectionFactory implements ConnectionFactoryInterface
{
    /**
     * @var DataBaseInfoRepository
     */
    private $baseRepository;

    public function __construct(DataBaseInfoRepository $baseRepository)
    {
        $this->baseRepository = $baseRepository;
    }

    /**
     * @param string $alias alias or full connection
     * @return Connection
     * @throws DBALException
     * @throws Exception
     */
    public function createConnection($alias) :Connection
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