<?php


namespace App\Builder;


use App\Collection\ColumnCollection;
use App\Entity\RemoteTableColumn;
use App\Entity\RemoteTable;
use Doctrine\DBAL\Schema\Column as ColumnInfo;

class ColumnCollectionByTableBuilder
{
    /**
     * @param RemoteTable $table
     * @return ColumnCollection
     */
    public function create(RemoteTable $table)
    {
        $columnInfoList = $table->getTableInfo()->getColumns();
        $columns = array_map(static function (ColumnInfo $columnInfo) use ($table)
        {
            $column = new RemoteTableColumn();
            return $column->setTable($table)
                ->setName($columnInfo->getName())
                ->setLabel($columnInfo->getName())
                ->setDescription($columnInfo->getComment() ?: "")
                ->setType($columnInfo->getType())
                ->setIsViewDetail(true);

        }, array_values($columnInfoList));

        $columnViewList = array_slice($columns, 0, 10);
        array_walk($columnViewList, static function (RemoteTableColumn $column)
        {
            $column->setIsViewList(true);
        });

        $columnPopup = array_slice($columns, 0, 20);
        array_walk($columnPopup, static function (RemoteTableColumn $column)
        {
            $column->setIsViewPopup(true);
        });

        return new ColumnCollection($columns);
    }
}