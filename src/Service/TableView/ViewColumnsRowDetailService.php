<?php


namespace App\Service\TableView;

use App\Collection\ColumnCollection;
use App\Entity\TableInfo;

/**
 * Class ViewColumnsRowDetailService
 * @package App\Service\TableView
 */
class ViewColumnsRowDetailService implements TableViewColumnsInterface
{
    /**
     * @param TableInfo $table
     * @return ColumnCollection
     */
    public function getColumns(TableInfo $table)
    {
        return $table->getColumns()
            ->filterByViewDetail();
    }
}