<?php


namespace App\Service\TableView;

use App\Collection\ColumnCollection;
use App\Entity\RemoteTable;

class ViewColumnsTableListService implements TableViewColumnsInterface
{
    /**
     * @param RemoteTable $table
     * @return ColumnCollection
     */
    public function getColumns(RemoteTable $table)
    {
        return $table->getColumns()
            ->filterByViewList();
    }
}