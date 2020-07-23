<?php


namespace App\Entity;

use App\Entity\EntityTrait\EntityIdentifierTrait;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * Class RemoteTableColumn
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\ColumnDecoratorRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorMap(value={ "rootEntity" = "App\Entity\ColumnDecorator", "detail" = "App\Entity\Decoretor\DetailDecorator" })
 * @ORM\DiscriminatorColumn(name="discriminator", type="string")
 */
abstract class ColumnDecorator
{
    use EntityIdentifierTrait;

    /**
     * @ManyToOne(targetEntity="App\Entity\RemoteTableColumn", inversedBy="decorators"))
     * @var RemoteTable
     */
    private $column;

    /**
     * @ORM\Column(type="json")
     * @var array|null
     */
    private $parameter;

    /**
     * @return string
     */
    abstract public function getType() :string ;

    /**
     * @return RemoteTable
     */
    public function getColumn(): RemoteTable
    {
        return $this->column;
    }

    /**
     * @param RemoteTable $column
     * @return ColumnDecorator
     */
    public function setColumn(RemoteTable $column): ColumnDecorator
    {
        $this->column = $column;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getParameter(): ?array
    {
        return $this->parameter;
    }

    /**
     * @param array|null $parameter
     * @return ColumnDecorator
     */
    public function setParameter(?array $parameter): ColumnDecorator
    {
        $this->parameter = $parameter;
        return $this;
    }


}