<?php


namespace App\Service;


use App\Entity\Column;
use App\Entity\Row;
use App\Entity\Table;
use App\Collection\RowsIterator;

class DataListTableService
{
    public function getRows(Table $table)
    {
        $queryBuilder = $table->getConnection()->createQueryBuilder();
        $queryBuilder->select($table->getFieldSet(Column::TYPE_LIST))
            ->from($table->getName())
            ->setMaxResults($table->getListRowCount());

        $query = $queryBuilder->getSQL();

        $dataRows = $table->getConnection()->fetchAll($query);
        $rows = array_map([$this, 'createRow'], $dataRows);

        return new RowsIterator($rows);
    }

    private function createRow($dataRow)
    {
        $row = new Row();
        $row->setData($dataRow);
        return $row;
    }
}