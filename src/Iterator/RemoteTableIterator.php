<?php


namespace App\Iterator;


use App\Builder\FilterIterator\FilterByIdBuilder;
use App\Entity\RemoteTable;
use ArrayObject;

class RemoteTableIterator extends ArrayObject
{
    /**
     * @param $id
     * @return RemoteTable|null
     */
    public function findById($id) :RemoteTable
    {
        return (new FilterByIdBuilder)->create($this->getIterator(), $id)->current();
    }
}