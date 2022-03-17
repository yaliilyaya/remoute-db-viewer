<?php


namespace App\Service;


use App\Entity\RemoteTableColumn;
use App\Entity\RemoteRow;
use App\Entity\RemoteTable;
use App\Collection\RowsIterator;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;

class DataListTableService
{
    /**
     * @param RemoteTable $table
     * @param array $filter
     * @return RowsIterator
     * @throws DBALException
     */
    public function getRows(RemoteTable $table, $filter = [])
    {
        $queryBuilder = $table->getConnection()->createQueryBuilder()            ;
        $queryBuilder->select($table->getFieldSet(RemoteTableColumn::TYPE_LIST))
            ->from($table->getName())
            ->setMaxResults($table->getListRowCount());

        if ($filter)
        {
            $filter = is_array($filter) ? $filter : [$filter];
            $queryBuilder->where(array_shift($filter));
            foreach ($filter as $key => $param) {
                $queryBuilder->setParameter($key, $param, is_array($param) ? Connection::PARAM_STR_ARRAY  : null);
            }
        }

        $dataRows = $queryBuilder->execute()->fetchAll();
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