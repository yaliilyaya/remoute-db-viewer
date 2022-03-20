<?php


namespace App\Builder;


use App\Collection\ColumnInfoCollection;
use App\Entity\TableInfo;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Schema\Column;

class ColumnCollectionByTableBuilder
{
    /**
     * @param TableInfo $table
     * @return ColumnInfoCollection
     * @throws DBALException
     */
    public function create(TableInfo $table)
    {
        $columnInfoList = $table->getTableInfo()->getColumns();
        $columns = array_map(static function (Column $columnInfo) use ($table)
        {
            $column = new Column();
            return $column->setName($columnInfo->getName())
                ->setLabel($columnInfo->getName())
                ->setDescription($columnInfo->getComment() ?: "")
                ->setType($columnInfo->getType())
                ->setIsViewDetail(true);

        }, array_values($columnInfoList));

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

        return new ColumnInfoCollection($columns);
    }
}