<?php

namespace RemoteDataBase\Service;

use App\Builder\ColumnCollectionByTableBuilder;
use App\Entity\TableInfo;
use App\Repository\ColumnInfoRepository;
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
     * @var ColumnInfoRepository
     */
    private $columnInfoRepository;

    /**
     * @param ColumnCollectionByTableBuilder $columnCollectionByTableBuilder
     * @param TableRemoteRepositoryBuilder $tableRemoteRepositoryBuilder
     * @param TableInfoRepository $tableInfoRepository
     */
    public function __construct(
        ColumnCollectionByTableBuilder $columnCollectionByTableBuilder,
        TableRemoteRepositoryBuilder $tableRemoteRepositoryBuilder,
        TableInfoRepository $tableInfoRepository,
        ColumnInfoRepository $columnInfoRepository
    ) {
        $this->columnCollectionByTableBuilder = $columnCollectionByTableBuilder;
        $this->tableRemoteRepositoryBuilder = $tableRemoteRepositoryBuilder;
        $this->tableInfoRepository = $tableInfoRepository;
        $this->columnInfoRepository = $columnInfoRepository;
    }

    /**
     * @param TableInfo $tableInfo
     * @return void
     * @throws ConnectionException
     */
    public function sync(TableInfo $tableInfo): void
    {
        $this->columnInfoRepository->removeByTable($tableInfo);

        $tableRemoteRepository = $this->tableRemoteRepositoryBuilder->create($tableInfo->getDataBase());
        $table = $tableRemoteRepository->getTableInfo($tableInfo->getName());
        $columns = $this->columnCollectionByTableBuilder->create($table->getColumns());
        $columns->setTable($tableInfo);
        $tableInfo->setColumns($columns);

        $this->tableInfoRepository->save($tableInfo);
    }
}