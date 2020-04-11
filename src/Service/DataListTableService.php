<?php


namespace App\Service;


use App\Entity\RemoteTableColumn;
use App\Entity\RemoteRow;
use App\Entity\RemoteTable;
use App\Collection\RowsIterator;

class DataListTableService
{
    public function getRows(RemoteTable $table)
    {
        $queryBuilder = $table->getConnection()->createQueryBuilder();
        $queryBuilder->select($table->getFieldSet(RemoteTableColumn::TYPE_LIST))
            ->from($table->getName())
            ->setMaxResults($table->getListRowCount());

        $query = $queryBuilder->getSQL();

        $dataRows = $table->getConnection()->fetchAll($query);
        $rows = array_map([$this, 'createRow'], $dataRows);

        return new RowsIterator($rows);
    }

    private function createRow($dataRow)
    {
        $row = new RemoteRow();
        $row->setData($dataRow);
        return $row;
    }
}