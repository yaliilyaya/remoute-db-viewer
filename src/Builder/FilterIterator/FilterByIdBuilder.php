<?php


namespace App\Builder\FilterIterator;


use App\FilterIterator\FilterById;
use FilterIterator;
use Iterator;

/**
 * Class FilterByIdBuilder
 * @package App\Builder\FilterIterator
 */
class FilterByIdBuilder
{
    /**
     * @param Iterator $iterator
     * @param $id
     * @return FilterIterator
     */
    public function create(Iterator $iterator , $id ): FilterIterator
    {
        return new FilterById($iterator, $id);
    }
}