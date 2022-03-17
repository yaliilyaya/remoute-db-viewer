<?php


namespace App\Collection;

use App\Entity\RemoteTable;
use App\Entity\RemoteTableColumn;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class ColumnIterator
 * @package App\Iterator
 * @method RemoteTableColumn current()
 */
class ColumnCollection extends ArrayCollection
{
    /**
     * @return ColumnCollection
     */
    public function filterByViewList()
    {
        $columns = array_filter($this->toArray(), function (RemoteTableColumn $column)
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
        $columns = array_filter($this->toArray(), function (RemoteTableColumn $column)
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
        $columns = array_filter($this->toArray(), function (RemoteTableColumn $column)
        {
            return $column->isViewPopup();
        });

        return new self($columns);
    }

    /**
     * TODO:: По возможности удалить
     * @param RemoteTable $table
     */
    public function setTable(RemoteTable $table): void
    {
        /** @var RemoteTableColumn $column */
        foreach ($this as $column)
        {
            $column->setTable($table);
        }
    }
}