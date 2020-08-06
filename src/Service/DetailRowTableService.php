<?php


namespace App\Service;


use App\Entity\RemoteTableColumn;
use App\Entity\RemoteRow;
use App\Entity\RemoteTable;
use Doctrine\DBAL\DBALException;

class DetailRowTableService
{

    /**
     * @param RemoteTable $table
     * @param int $id
     * @return RemoteRow|null
     */
    public function getRow(RemoteTable $table, $id): ?RemoteRow
    {
        try {
            $queryBuilder = $table->getConnection()->createQueryBuilder();
        } catch (DBALException $e) {
            return null;
        }
        //TODO:: filter field
        $queryBuilder->select($table->getFieldSet(RemoteTableColumn::TYPE_DETAIL))
            ->from($table->getDatabase()->getDb() .'.'.$table->getName())
            ->where('id = :id');

        $query = $queryBuilder->getSQL();


        try {
            $dataRow = $table->getConnection()->fetchAssoc($query, ['id' => $id]);
        } catch (DBALException $e) {
            return null;
        }

        if (!$dataRow) {
            return null;
        }

        $row = new RemoteRow();
        $row->setData($dataRow);
        return $row;
    }
}