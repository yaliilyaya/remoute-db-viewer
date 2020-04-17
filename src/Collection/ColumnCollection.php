<?php


namespace App\Collection;

use App\Entity\RemoteTableColumn;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class ColumnIterator
 * @package App\Iterator
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
}