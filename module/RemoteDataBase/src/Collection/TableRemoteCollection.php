<?php

namespace RemoteDataBase\Collection;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Schema\Table;

class TableRemoteCollection extends ArrayCollection
{
    /**
     * @param string $name
     * @return Table
     */
    public function findByTableName(string $name): ?Table
    {
        $items = iterator_to_array($this);
        return current(array_filter($items, function (Table $item) use ($name) {
            return $item->getName() === $name;
        })) ?: null;
    }
}