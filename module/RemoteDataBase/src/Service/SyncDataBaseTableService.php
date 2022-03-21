<?php

namespace RemoteDataBase\Service;

use App\Builder\ColumnCollectionByTableBuilder;
use App\Entity\DataBaseInfo;
use App\Entity\TableInfo;
use App\Repository\TableInfoRepository;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Schema\Table;
use RemoteDataBase\Builder\TableRemoteRepositoryBuilder;
use RemoteDataBase\Exception\ConnectionException;

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
     * @var ColumnCollectionByTableBuilder
     */
    private $columnCollectionByTableBuilder;

    /**
     * @param TableInfoRepository $tableInfoRepository
     * @param TableRemoteRepositoryBuilder $tableRemoteRepositoryBuilder
     * @param ColumnCollectionByTableBuilder $columnCollectionByTableBuilder
     */
    public function __construct(
        TableInfoRepository $tableInfoRepository,
        TableRemoteRepositoryBuilder $tableRemoteRepositoryBuilder,
        ColumnCollectionByTableBuilder $columnCollectionByTableBuilder
    ) {
        $this->tableRemoteRepositoryBuilder = $tableRemoteRepositoryBuilder;
        $this->tableInfoRepository = $tableInfoRepository;
        $this->columnCollectionByTableBuilder = $columnCollectionByTableBuilder;
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
        $this->syncTableColumns($tableInfoList);
        dump($tableInfoList);
        die(__FILE__);
        $this->tableInfoRepository->saveAll($tableInfoList);
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
            ->setDataBase($dataBase);

        return $tableInfo;
    }

    private function syncTableColumns(array $tables)
    {
        /** @var Table $table */
        $table = current($tables);
        /** @var TableInfo $tableInfo */
        $tableInfo = null;
        $columns = $table->getColumns();
        $columnInfoList = $this->columnCollectionByTableBuilder->create($columns);
        $columnInfoList->setTable($tableInfo);
        $tableInfo->setColumns($columnInfoList);
    }
}