<?php


namespace App\Builder;


use App\Collection\ColumnCollection;
use App\Entity\Column;
use App\Entity\Table;
use Doctrine\DBAL\Schema\Column as ColumnInfo;

class ColumnCollectionByTableBuilder
{
    /**
     * @param Table $table
     * @return ColumnCollection
     */
    public function create(Table $table)
    {
        $columnInfoList = $table->getTableInfo()->getColumns();
        $columns = array_map(static function (ColumnInfo $columnInfo)
        {
            $column = new Column();
            return $column->setName($columnInfo->getName())
                ->setLabel($columnInfo->getName())
                ->setDescription($columnInfo->getComment() ?: "")
                ->setType($columnInfo->getType())
                ->setIsViewDetail(true);

        }, $columnInfoList);

        $columnViewList = array_slice($columns, 0, 10);
        array_walk($columnViewList, static function (Column $column)
        {
            $column->setIsViewList(true);
        });

        $columnPopup = array_slice($columns, 0, 20);
        array_walk($columnPopup, static function (Column $column)
        {
            $column->setIsViewPopup(true);
        });

        return new ColumnCollection($columns);
    }
}