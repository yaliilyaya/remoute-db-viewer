<?php


namespace App\Service\TableView;

use App\Collection\ColumnCollection;
use App\Entity\Table;

class ViewColumnsTableListService implements TableViewColumnsInterface
{
    /**
     * @param Table $table
     * @return ColumnCollection
     */
    public function getColumns(Table $table)
    {
        return $table->getColumns()
            ->filterByViewList();
    }
}