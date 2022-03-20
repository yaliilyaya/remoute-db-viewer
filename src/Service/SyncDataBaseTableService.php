<?php

namespace App\Service;

use App\Builder\TableRemoteRepositoryBuilder;
use App\Entity\DataBaseInfo;
use App\Entity\TableInfo;
use App\Exception\ConnectionException;
use App\Factory\ConnectionBuilder;
use App\Factory\ConnectionFactory;
use App\Repository\TableInfoRepository;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Schema\Table;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class SyncRemoteTableService
 * @package App\Service
 */
class SyncDataBaseTableService
{
    /**
     * @var TableRemoteRepositoryBuilder
     */
    private $tableRemoteRepositoryBuilder;
    /**
     * @var TableInfoRepository
     */
    private $tableInfoRepository;

    /**
     * @param TableInfoRepository $tableInfoRepository
     * @param TableRemoteRepositoryBuilder $tableRemoteRepositoryBuilder
     */
    public function __construct(
        TableInfoRepository $tableInfoRepository,
        TableRemoteRepositoryBuilder $tableRemoteRepositoryBuilder
    ) {
        $this->tableRemoteRepositoryBuilder = $tableRemoteRepositoryBuilder;
        $this->tableInfoRepository = $tableInfoRepository;
    }

    /**
     * @param DataBaseInfo $dataBase
     * @throws ConnectionException
     */
    public function sync(DataBaseInfo $dataBase)
    {
        $tableRemoteRepository = $this->tableRemoteRepositoryBuilder->create($dataBase);
        $tables = $tableRemoteRepository->findAll();
        $tableInfoList = $this->createTableInfoList($tables, $dataBase);
        $this->tableInfoRepository->saveAll($tableInfoList);
    }

    /**
     * @param DataBaseInfo $dataBase
     * @return array
     * @throws ConnectionException
     */
    private function getTables(DataBaseInfo $dataBase)
    {
        $connection = $this->connectionByDataBaseFactory->createConnection($dataBase);
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
    /**
     * @param Table[] $tables
     * @param DataBaseInfo $dataBase
     * @return TableInfo[]
     */
    private function createTableInfoList(array $tables, DataBaseInfo $dataBase): array
    {
        return array_map(function (Table $table) use ($dataBase)
        {
            return $this->createTableInfo($table, $dataBase);
        }, $tables);
    }

    /**
     * @param Table $table
     * @param DataBaseInfo $dataBase
     * @return TableInfo
     */
    private function createTableInfo(Table $table, DataBaseInfo $dataBase): TableInfo
    {
        $tableInfo = new TableInfo();
        $tableInfo->setName($table->getName())
            ->setLabel($table->getName())
            ->setDatabase($dataBase);

        return $tableInfo;
    }
}