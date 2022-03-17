<?php


namespace App\Service\TableView;

use App\Collection\ColumnCollection;
use App\Entity\RemoteTable;

/**
 * Class ViewColumnsRowDetailService
 * @package App\Service\TableView
 */
class ViewColumnsRowDetailService implements TableViewColumnsInterface
{
    /**
     * @param RemoteTable $table
     * @return ColumnCollection
     */
    public function getColumns(RemoteTable $table)
    {
        return $table->getColumns()
            ->filterByViewDetail();
    }
}