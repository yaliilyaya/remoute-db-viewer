<?php


namespace App\Collection;

use App\Entity\Column;
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
        $columns = array_filter($this->toArray(), function (Column $column)
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
        $columns = array_filter($this->toArray(), function (Column $column)
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
        $columns = array_filter($this->toArray(), function (Column $column)
        {
            return $column->isViewPopup();
        });

        return new self($columns);
    }
}