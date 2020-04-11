<?php

namespace App\Service;

use App\Entity\DataBase;
use App\Entity\RemoteTable;
use App\Factory\ConnectionFactory;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class SyncRemoteTableService
 * @package App\Service
 */
class SyncRemoteTableService
{
    /**
     * @var RemoteTableNamesService
     */
    private $remoteTableNamesService;
    /**
     * @var ConnectionFactory
     */
    private $connectionFactory;
    /**
     * @var RemoteTableInfoService
     */
    private $remoteTableInfoService;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * SyncRemoteTableService constructor.
     * @param RemoteTableNamesService $remoteTableNamesService
     * @param RemoteTableInfoService $remoteTableInfoService
     * @param ConnectionFactory $connectionFactory
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        RemoteTableNamesService $remoteTableNamesService,
        RemoteTableInfoService $remoteTableInfoService,
        ConnectionFactory $connectionFactory,
        EntityManagerInterface $entityManager
    ) {
        $this->remoteTableNamesService = $remoteTableNamesService;
        $this->remoteTableInfoService = $remoteTableInfoService;
        $this->connectionFactory = $connectionFactory;
        $this->entityManager = $entityManager;
    }

    /**
     * @param DataBase[] $dataBases
     */
    public function sync(array $dataBases)
    {
        $tables = $this->findTables($dataBases);
        array_walk($tables, [$this->entityManager, 'persist']);
        $this->entityManager->flush();
    }

    /**
     * @param DataBase $dataBase
     * @return array
     */
    private function getTables(DataBase $dataBase)
    {
        try {
            $connection = $this->connectionFactory->createConnection($dataBase->getAlias());
        } catch (DBALException $e) {
            return [];
        } catch (\Exception $e) {
            return [];
        }
        $tableNames = $this->remoteTableNamesService->getNames($connection);

        return array_map(function ($tableName) use ($connection)
        {
            try {
                $table = $this->remoteTableInfoService->getTableInfo($connection, $tableName);
            } catch (DBALException $e) {
                $table =  new RemoteTable();
                $table->setIsActive(false);
            }

            $table->setName($tableName)
                ->setLabel($tableName);
            return $table;
        }, $tableNames);
    }

    private function findTables(array $dataBases)
    {
        $tables = array_map(function (DataBase $dataBase)
        {
            try {
                return $this->getTables($dataBase);
            } catch (DBALException $e) {
                return  [];
            }
        }, $dataBases);

        return $tables ? array_merge(...$tables) : [];
    }
}