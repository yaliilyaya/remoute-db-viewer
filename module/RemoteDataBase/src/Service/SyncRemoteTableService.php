<?php

namespace RemoteDataBase\Service;

use App\Builder\ColumnCollectionByTableBuilder;
use App\Entity\TableInfo;
use App\Repository\TableInfoRepository;
use RemoteDataBase\Builder\TableRemoteRepositoryBuilder;
use RemoteDataBase\Exception\ConnectionException;

/**
 * Class SyncRemoteTableService
 * @package App\Service
 */
class SyncRemoteTableService
{
    /**
     * @var ColumnCollectionByTableBuilder
     */
    private $columnCollectionByTableBuilder;
    /**
     * @var TableRemoteRepositoryBuilder
     */
    private $tableRemoteRepositoryBuilder;
    /**
     * @var TableInfoRepository
     */
    private $tableInfoRepository;

    /**
     * @param ColumnCollectionByTableBuilder $columnCollectionByTableBuilder
     * @param TableRemoteRepositoryBuilder $tableRemoteRepositoryBuilder
     * @param TableInfoRepository $tableInfoRepository
     */
    public function __construct(
        ColumnCollectionByTableBuilder $columnCollectionByTableBuilder,
        TableRemoteRepositoryBuilder $tableRemoteRepositoryBuilder,
        TableInfoRepository $tableInfoRepository
    ) {
        $this->columnCollectionByTableBuilder = $columnCollectionByTableBuilder;
        $this->tableRemoteRepositoryBuilder = $tableRemoteRepositoryBuilder;
        $this->tableInfoRepository = $tableInfoRepository;
    }

    /**
     * @param TableInfo $tableInfo
     * @return void
     * @throws ConnectionException
     */
    public function sync(TableInfo $tableInfo): void
    {
        $tableRemoteRepository = $this->tableRemoteRepositoryBuilder->create($tableInfo->getDataBase());
        $table = $tableRemoteRepository->getTableInfo($tableInfo->getName());
        $columns = $this->columnCollectionByTableBuilder->create($table->getColumns());
        $columns->setTable($tableInfo);
        $tableInfo->setColumns($columns);

        $this->tableInfoRepository->save($tableInfo);
    }
}