<?php


namespace App\Service\TableView;

use App\Collection\ColumnInfoCollection;
use App\Entity\TableInfo;

/**
 * Class ViewColumnsRowDetailService
 * @package App\Service\TableView
 */
class ViewColumnsRowDetailService implements TableViewColumnsInterface
{
    /**
     * @param TableInfo $table
     * @return ColumnInfoCollection
     */
    public function getColumns(TableInfo $table)
    {
        return $table->getColumns()
            ->filterByViewDetail();
    }
}