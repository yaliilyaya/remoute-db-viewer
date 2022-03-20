<?php


namespace App\Service\TableView;

use App\Collection\ColumnInfoCollection;
use App\Entity\TableInfo;

class ViewColumnsTableListService implements TableViewColumnsInterface
{
    /**
     * @param TableInfo $table
     * @return ColumnInfoCollection
     */
    public function getColumns(TableInfo $table)
    {
        return $table->getColumns()
            ->filterByViewList();
    }
}