<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * Class ColumnInfo
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\ColumnDecoratorRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorMap(value={ "rootEntity" = "App\Entity\ColumnDecorator", "detail" = "App\Entity\Decoretor\DetailDecorator" })
 * @ORM\DiscriminatorColumn(name="discriminator", type="string")
 */
class ColumnDecorator
{
    use IdentifierTrait;

    /**
     * @ManyToOne(targetEntity="App\Entity\ColumnInfo", inversedBy="decorators"))
     * @var TableInfo
     */
    private $column;

    /**
     * @ORM\Column(type="json")
     * @var array|null
     */
    private $parameter;

}