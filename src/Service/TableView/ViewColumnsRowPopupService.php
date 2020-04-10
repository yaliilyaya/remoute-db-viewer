<?php


namespace App\Service\TableView;

use App\Collection\ColumnCollection;
use App\Entity\Table;

/**
 * Class ViewColumnsRowDetailService
 * @package App\Service\TableView
 */
class ViewColumnsRowPopupService implements TableViewColumnsInterface
{
    /**
     * @param Table $table
     * @return ColumnCollection
     */
    public function getColumns(Table $table)
    {
        return $table->getColumns()
            ->filterByViewPopup();
    }
}