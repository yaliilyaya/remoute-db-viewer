<?php


namespace App\Service;


use App\Entity\ColumnInfo;
use App\Entity\TableInfo;
use App\Model\RowValue;
use Doctrine\DBAL\DBALException;

class DetailRowTableService
{

    /**
     * @param TableInfo $table
     * @param int $id
     * @return RowValue|null
     */
    public function getRow(TableInfo $table, $id): ?RowValue
    {
        try {
            $queryBuilder = $table->getConnection()->createQueryBuilder();
        } catch (DBALException $e) {
            return null;
        }
        //TODO:: filter field
        $queryBuilder->select($table->getFieldSet(ColumnInfo::TYPE_DETAIL))
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

        $row = new RowValue();
        $row->setData($dataRow);
        return $row;
    }
}