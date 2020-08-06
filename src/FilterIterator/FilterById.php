<?php


namespace App\FilterIterator;

use App\Entity\IdentifierInterface;
use FilterIterator;
use Iterator;

/**
 * Class FilterById
 * @package App\FilterIterator
 */
class FilterById extends FilterIterator
{
    /**
     * @var int
     */
    private $id;

    public function __construct(Iterator $iterator , $id )
    {
        parent::__construct($iterator);
        $this->id = $id;
    }

    /**
     * @inheritDoc
     */
    public function accept() :bool
    {
        /** @var IdentifierInterface $item */
        $item = $this->getInnerIterator()->current();

        return $item->getId() === $this->id;
    }
}