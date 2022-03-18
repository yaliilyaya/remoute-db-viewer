<?php


namespace App\Twig;

use App\Entity\Decoretor\DetailDecorator;
use App\Entity\ColumnInfo;
use Doctrine\ORM\PersistentCollection;
use Twig\Extension\RuntimeExtensionInterface;

class ColumnDecoratorExtension implements RuntimeExtensionInterface
{
    /**
     * @param $value
     * @param ColumnInfo $column
     * @return mixed
     */
    public function applyColumnDecorator($value, $column)
    {

        /** @var DetailDecorator $decorator */
        $decorator = $column->getDecorators()->current();
        return $decorator ? $decorator->execute($value, $column) : $value ;
    }
}