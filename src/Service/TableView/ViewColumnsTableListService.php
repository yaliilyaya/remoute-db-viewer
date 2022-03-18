<?php


namespace App\Service\TableView;

use App\Collection\ColumnCollection;
use App\Entity\TableInfo;

class ViewColumnsTableListService implements TableViewColumnsInterface
{
    /**
     * @param TableInfo $table
     * @return ColumnCollection
     */
    public function getColumns(TableInfo $table)
    {
        return $table->getColumns()
            ->filterByViewList();
    }
}