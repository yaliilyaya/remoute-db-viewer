<?php


namespace App\Entity\Decoretor;

use App\Entity\ColumnDecorator;
use App\Entity\ColumnInfo;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class RootEntity
 *
 * @ORM\Entity()
 * @ NNXD\DiscriminatorEntry(value="detail")
 */
class DetailDecorator extends  ColumnDecorator
{
    /**
     * @param $value
     * @param ColumnInfo $column
     * @return mixed
     */
    public function execute($value, $column)
    {
        $tableName = $column->getTable()->getName();
        $dbName = $column->getTable()->getDataBase()->getAlias();
        return "<a href='/detail/{$dbName}/{$tableName}/{$value}'>#{$value}</a>";
    }
}