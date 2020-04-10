<?php


namespace App\Service\TableView;


use App\Entity\Table;

interface TableViewColumnsInterface
{
    /**
     * @param Table $table
     * @return array
     */
    public function getColumns(Table $table);
}