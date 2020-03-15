<?php


namespace App\Service;


use App\Entity\Column;
use App\Entity\Row;
use App\Entity\Table;
use App\Iterator\RowsIterator;
use Doctrine\DBAL\DBALException;

class DetailRowTableService
{

    public function getRow(Table $table, $id)
    {
        $queryBuilder = $table->getConnection()->createQueryBuilder();
        //TODO:: filter field
        $queryBuilder->select($table->getFieldSet(Column::TYPE_DETAIL))
            ->from($table->getName())
            ->setMaxResults(1);

        $query = $queryBuilder->getSQL();

        try {
            $dataRow = $table->getConnection()->fetchAssoc($query);
        } catch (DBALException $e) {
            return null;
        }
        $row = new Row();
        $row->setData($dataRow);
        return $row;
    }
}