<?php


namespace App\Service;


use App\Collection\RowsIterator;
use App\Entity\ColumnInfo;
use App\Entity\TableInfo;
use App\Model\RowValue;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use RemoteDataBase\Builder\RowRemoteRepositoryBuilder;
use RemoteDataBase\Builder\TableRemoteRepositoryBuilder;

class DataListTableService
{
    /**
     * @var RowRemoteRepositoryBuilder
     */
    private $rowRemoteRepositoryBuilder;

    public function __construct(RowRemoteRepositoryBuilder $rowRemoteRepositoryBuilder)
    {
        $this->rowRemoteRepositoryBuilder = $rowRemoteRepositoryBuilder;
    }

    /**
     * @param TableInfo $table
     * @param array $filter
     * @return RowsIterator
     * @throws DBALException
     */
    public function getRows(TableInfo $tableInfo, $filter = [])
    {
        $rowRemoteRepository = $this->rowRemoteRepositoryBuilder->create($tableInfo);

        $dataRows = $rowRemoteRepository->findBy($filter, $tableInfo->getListRowCount());
        $rows = array_map([$this, 'createRow'], $dataRows);

        return new RowsIterator($rows);
    }

    private function createRow($dataRow)
    {
        $row = new RowValue();
        $row->setData($dataRow);
        return $row;
    }
}