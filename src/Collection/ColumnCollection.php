<?php


namespace App\Collection;

use App\Entity\TableInfo;
use App\Entity\ColumnInfo;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class ColumnIterator
 * @package App\Iterator
 * @method ColumnInfo current()
 */
class ColumnCollection extends ArrayCollection
{
    /**
     * @return ColumnCollection
     */
    public function filterByViewList()
    {
        $columns = array_filter($this->toArray(), function (ColumnInfo $column)
        {
            return $column->isViewList();
        });

        return new self($columns);
    }

    /**
     * @return ColumnCollection
     */
    public function filterByViewDetail()
    {
        $columns = array_filter($this->toArray(), function (ColumnInfo $column)
        {
            return $column->isViewDetail();
        });

        return new self($columns);
    }

    /**
     * @return ColumnCollection
     */
    public function filterByViewPopup()
    {
        $columns = array_filter($this->toArray(), function (ColumnInfo $column)
        {
            return $column->isViewPopup();
        });

        return new self($columns);
    }

    /**
     * TODO:: По возможности удалить
     * @param TableInfo $table
     */
    public function setTable(TableInfo $table): void
    {
        /** @var ColumnInfo $column */
        foreach ($this as $column)
        {
            $column->setTable($table);
        }
    }
}