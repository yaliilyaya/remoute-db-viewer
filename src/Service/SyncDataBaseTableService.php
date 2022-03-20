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
        $tables = $tableRemoteRepository->findAll($dataBase);
        $this->tableInfoRepository->saveAll($tables);
    }

//    /**
//     * @param DataBaseInfo $dataBase
//     * @return array
//     * @throws ConnectionException
//     */
//    private function getTables(DataBaseInfo $dataBase)
//    {
//        $connection = $this->connectionByDataBaseFactory->createConnection($dataBase);
//        $tableNames = $this->remoteTableNamesService->getNames($connection);
//
//        return array_map(function ($tableName) use ($connection, $dataBase)
//        {
//            try {
//                $table = $this->remoteTableInfoService->getTableInfo($connection, $tableName);
//            } catch (DBALException $e) {
//                $table =  new TableInfo();
//                $table->setIsActive(false);
//            }
//
//            $table->setName($tableName)
//                ->setLabel($tableName)
//                ->setDatabase($dataBase);
//            return $table;
//        }, $tableNames);
//    }
}