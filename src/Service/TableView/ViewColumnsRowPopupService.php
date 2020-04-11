<?php


namespace App\Service\TableView;

use App\Collection\ColumnCollection;
use App\Entity\RemoteTable;

/**
 * Class ViewColumnsRowDetailService
 * @package App\Service\TableView
 */
class ViewColumnsRowPopupService implements TableViewColumnsInterface
{
    /**
     * @param RemoteTable $table
     * @return ColumnCollection
     */
    public function getColumns(RemoteTable $table)
    {
        return $table->getColumns()
            ->filterByViewPopup();
    }
}