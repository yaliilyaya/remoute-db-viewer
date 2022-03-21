<?php

namespace App\Builder;

use App\Collection\ColumnInfoCollection;
use App\Entity\ColumnInfo;
use App\Entity\TableInfo;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Schema\Column;

class ColumnCollectionByTableBuilder
{
    /**
     * @param Column[] $columns
     * @return ColumnInfoCollection
     */
    public function create(array $columns)
    {
        $columns = array_map(static function (Column $column)
        {
            $columnInfo = new ColumnInfo();
            return $columnInfo->setName($column->getName())
                ->setLabel($column->getName())
                ->setDescription($column->getComment() ?: "")
                ->setType($column->getType())
                ->setIsViewDetail(true);

        }, array_values($columns));

        $columnViewList = array_slice($columns, 0, 10);
        array_walk($columnViewList, static function (ColumnInfo $columnInfo)
        {
            $columnInfo->setIsViewList(true);
        });

        $columnPopup = array_slice($columns, 0, 20);
        array_walk($columnPopup, static function (ColumnInfo $columnInfo)
        {
            $columnInfo->setIsViewPopup(true);
        });

        return new ColumnInfoCollection($columns);
    }
}