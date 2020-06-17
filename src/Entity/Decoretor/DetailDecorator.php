<?php


namespace App\Entity\Decoretor;

use App\Entity\ColumnDecorator;
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
     * @return mixed
     */
    public function execute($value)
    {
        return "<a href='{$value}'>#{$value}</a>";
    }
}