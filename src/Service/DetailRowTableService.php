<?php


namespace App\Service;


use App\Entity\RemoteTableColumn;
use App\Entity\RemoteRow;
use App\Entity\RemoteTable;
use App\Collection\RowsIterator;
use Doctrine\DBAL\DBALException;

class DetailRowTableService
{

    public function getRow(RemoteTable $table, $id)
    {
        $queryBuilder = $table->getConnection()->createQueryBuilder();
        //TODO:: filter field
        $queryBuilder->select($table->getFieldSet(RemoteTableColumn::TYPE_DETAIL))
            ->from($table->getName())
            ->where('id = :id')
            ->setParameter('id', $id);

        $query = $queryBuilder->getSQL();

        try {
            $dataRow = $table->getConnection()->fetchAssoc($query);
        } catch (DBALException $e) {
            return null;
        }
        $row = new RemoteRow();
        $row->setData($dataRow);
        return $row;
    }
}