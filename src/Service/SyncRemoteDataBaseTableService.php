<?php

namespace App\Service;

use App\Entity\DataBaseInfo;
use App\Entity\TableInfo;
use App\Factory\ConnectionByDataBaseFactory;
use App\Factory\ConnectionFactory;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class SyncRemoteTableService
 * @package App\Service
 */
class SyncRemoteDataBaseTableService
{
    /**
     * @var RemoteTableNamesService
     */
    private $remoteTableNamesService;
    /**
     * @var RemoteTableInfoService
     */
    private $remoteTableInfoService;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var ConnectionByDataBaseFactory
     */
    private $connectionByDataBaseFactory;

    /**
     * SyncRemoteTableService constructor.
     * @param RemoteTableNamesService $remoteTableNamesService
     * @param RemoteTableInfoService $remoteTableInfoService
     * @param ConnectionByDataBaseFactory $connectionByDataBaseFactory
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        RemoteTableNamesService $remoteTableNamesService,
        RemoteTableInfoService $remoteTableInfoService,
        ConnectionByDataBaseFactory $connectionByDataBaseFactory,
        EntityManagerInterface $entityManager
    ) {
        $this->remoteTableNamesService = $remoteTableNamesService;
        $this->remoteTableInfoService = $remoteTableInfoService;
        $this->entityManager = $entityManager;
        $this->connectionByDataBaseFactory = $connectionByDataBaseFactory;
    }

    /**
     * @param DataBaseInfo $dataBase
     */
    public function sync(DataBaseInfo $dataBase)
    {
        $tables = $this->getTables($dataBase);
        array_walk($tables, [$this->entityManager, 'persist']);
        $this->entityManager->flush();
    }

    /**
     * @param DataBaseInfo $dataBase
     * @return array
     */
    private function getTables(DataBaseInfo $dataBase)
    {
        try {
            $connection = $this->connectionByDataBaseFactory->createConnection($dataBase);
        } catch (DBALException $e) {
            return [];
        } catch (\Exception $e) {
            return [];
        }

        $tableNames = $this->remoteTableNamesService->getNames($connection);

        return array_map(function ($tableName) use ($connection, $dataBase)
        {
            try {
                $table = $this->remoteTableInfoService->getTableInfo($connection, $tableName);
            } catch (DBALException $e) {
                $table =  new TableInfo();
                $table->setIsActive(false);
            }

            $table->setName($tableName)
                ->setLabel($tableName)
                ->setDatabase($dataBase);
            return $table;
        }, $tableNames);
    }

}