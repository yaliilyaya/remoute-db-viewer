<?php

namespace App\Entity;

use App\Collection\ColumnInfoCollection;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Table;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\PersistentCollection;

/**
 * Class Table
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\RemoteTableRepository")
 * @uses ORM
 * @uses ManyToOne
 * @uses OneToMany
 */
class TableInfo
{
    use IdentifierTrait;

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var Table
     */
    private $tableInfo;

    /**
     * @ORM\Column(type="string", length=150)
     * @var string|null
     */
    private $label;
    /**
     * @ORM\Column(type="string", length=150)
     * @var string|null
     */
    private $name;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string|null
     */
    private $description;
    /**
     * @ORM\Column(type="boolean", options={"default": "1"})
     * @var boolean
     */
    private $isActive;
    /**
     * @var DataBaseInfo
     * @ManyToOne(targetEntity="App\Entity\DataBaseInfo", inversedBy="tables")
     */
    private $dataBase;
    /**
     * @OneToMany(targetEntity="App\Entity\ColumnInfo", mappedBy="table", cascade={"persist"})
     * @var PersistentCollection
     */
    private $columns;

    public function __construct()
    {
        $this->isActive = true;
    }

    /**
     * @return ColumnInfoCollection
     */
    public function getColumns(): ColumnInfoCollection
    {
        return new ColumnInfoCollection($this->columns ? iterator_to_array($this->columns): []);
    }

    /**
     * @param ColumnInfoCollection $columns
     * @return TableInfo
     */
    public function setColumns(ColumnInfoCollection $columns): TableInfo
    {
        $this->columns = $columns;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return TableInfo
     */
    public function setName(?string $name): TableInfo
    {
        $this->name = $name;
        return $this;
    }

    public function getListRowCount(): int
    {
        return 20;
    }

    public function getFieldSet(string $fieldSet): array
    {
        return ['*'];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return TableInfo
     */
    public function setId(int $id): TableInfo
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * @param string|null $label
     * @return TableInfo
     */
    public function setLabel(?string $label): TableInfo
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return TableInfo
     */
    public function setDescription(?string $description): TableInfo
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     * @return TableInfo
     */
    public function setIsActive(bool $isActive): TableInfo
    {
        $this->isActive = $isActive;
        return $this;
    }

    /**
     * @return DataBaseInfo
     */
    public function getDataBase(): DataBaseInfo
    {
        return $this->dataBase;
    }

    /**
     * @param DataBaseInfo $dataBase
     * @return TableInfo
     */
    public function setDataBase(DataBaseInfo $dataBase): TableInfo
    {
        $this->dataBase = $dataBase;
        return $this;
    }

}