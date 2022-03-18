<?php

namespace App\Entity;

use App\Collection\ColumnCollection;
use App\Entity\EntityTrait\EntityIdentifierTrait;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Schema\Table;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\PersistentCollection;

/**
 * Class Table
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\RemoteTableRepository")
 */
class TableInfo
{
    use EntityIdentifierTrait;

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var DelayedConnection
     */
    private $delayedConnection;

    /**
     * @var Table
     */
    private $tableInfo;

    /**
     * @ORM\Column(type="string", length=50)
     * @var string|null
     */
    private $label;
    /**
     * @ORM\Column(type="string", length=50)
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
    private $database;
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
     * @return Connection
     * @throws DBALException
     */
    public function getConnection() : Connection
    {
        return $this->connection ?? $this->connection = $this->delayedConnection->getConnection();
    }

    /**
     * @param Connection $connection
     * @return TableInfo
     */
    public function setConnection($connection)
    {
        $this->connection = $connection;
        return $this;
    }

    /**
     * @param DelayedConnection $delayedConnection
     * @return TableInfo
     */
    public function setDelayedConnection(DelayedConnection $delayedConnection): Table
    {
        $this->delayedConnection = $delayedConnection;
        return $this;
    }

    /**
     * @return Table
     * @throws DBALException
     */
    public function getTableInfo(): Table
    {
        return $this->tableInfo ?? $this->tableInfo = $this->delayedConnection->getTableInfo();
    }

    /**
     * @param TableInfo $tableInfo
     * @return TableInfo
     */
    public function setTableInfo(TableInfo $tableInfo): TableInfo
    {
        $this->tableInfo = $tableInfo;
        return $this;
    }

    /**
     * @return ColumnCollection
     */
    public function getColumns(): ColumnCollection
    {
        $columns = $this->columns ? iterator_to_array($this->columns) : $this->delayedConnection->getColumns();
        return new ColumnCollection($columns);
    }

    /**
     * @param ColumnCollection $columns
     * @return TableInfo
     */
    public function setColumns(ColumnCollection $columns): TableInfo
    {
        $this->columns = $columns;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name ?? $this->tableInfo->getName();
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

    public function getListRowCount()
    {
        return 20;
    }

    public function getFieldSet(string $fieldSet)
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
    public function getDatabase(): DataBaseInfo
    {
        return $this->database;
    }

    /**
     * @param DataBaseInfo $database
     * @return TableInfo
     */
    public function setDatabase(DataBaseInfo $database): TableInfo
    {
        $this->database = $database;
        return $this;
    }

}