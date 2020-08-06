<?php


namespace App\Iterator;


use App\Builder\FilterIterator\FilterByIdBuilder;
use App\Entity\RemoteTable;
use App\Entity\RemoteTableColumn;
use ArrayObject;

class RemoteTableColumnIterator extends ArrayObject
{
    /**
     * @param $id
     * @return RemoteTableColumn|null
     */
    public function findById($id) :?RemoteTableColumn
    {
        return (new FilterByIdBuilder)->create($this->getIterator(), $id)->current();
    }
}