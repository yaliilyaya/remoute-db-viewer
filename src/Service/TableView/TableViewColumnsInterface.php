<?php


namespace App\Service\TableView;


use App\Entity\TableInfo;

interface TableViewColumnsInterface
{
    /**
     * @param TableInfo $table
     * @return array
     */
    public function getColumns(TableInfo $table);
}