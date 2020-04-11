<?php


namespace App\Service\TableView;


use App\Entity\RemoteTable;

interface TableViewColumnsInterface
{
    /**
     * @param RemoteTable $table
     * @return array
     */
    public function getColumns(RemoteTable $table);
}