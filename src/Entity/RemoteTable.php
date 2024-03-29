<?php

namespace App\Entity;

use App\Collection\ColumnCollection;
use App\Entity\EntityTrait\EntityIdentifierTrait;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Schema\Table as TableInfo;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\PersistentCollection;

/**
 * Class Table
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\RemoteTableRepository")
 */
class RemoteTable
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
     * @var TableInfo
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
     * @var RemoteDataBase
     * @ManyToOne(targetEntity="App\Entity\RemoteDataBase", inversedBy="tables")
     */
    private $database;
    /**
     * @OneToMany(targetEntity="App\Entity\RemoteTableColumn", mappedBy="table", cascade={"persist"})
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
     * @return RemoteTable
     */
    public function setConnection($connection)
    {
        $this->connection = $connection;
        return $this;
    }

    /**
     * @param DelayedConnection $delayedConnection
     * @return RemoteTable
     */
    public function setDelayedConnection(DelayedConnection $delayedConnection): RemoteTable
    {
        $this->delayedConnection = $delayedConnection;
        return $this;
    }

    /**
     * @return TableInfo
     * @throws DBALException
     */
    public function getTableInfo(): TableInfo
    {
        return $this->tableInfo ?? $this->tableInfo = $this->delayedConnection->getTableInfo();
    }

    /**
     * @param TableInfo $tableInfo
     * @return RemoteTable
     */
    public function setTableInfo(TableInfo $tableInfo): RemoteTable
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
     * @return RemoteTable
     */
    public function setColumns(ColumnCollection $columns): RemoteTable
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
     * @return RemoteTable
     */
    public function setName(?string $name): RemoteTable
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
     * @return RemoteTable
     */
    public function setId(int $id): RemoteTable
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
     * @return RemoteTable
     */
    public function setLabel(?string $label): RemoteTable
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
     * @return RemoteTable
     */
    public function setDescription(?string $description): RemoteTable
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
     * @return RemoteTable
     */
    public function setIsActive(bool $isActive): RemoteTable
    {
        $this->isActive = $isActive;
        return $this;
    }

    /**
     * @return RemoteDataBase
     */
    public function getDatabase(): RemoteDataBase
    {
        return $this->database;
    }

    /**
     * @param RemoteDataBase $database
     * @return RemoteTable
     */
    public function setDatabase(RemoteDataBase $database): RemoteTable
    {
        $this->database = $database;
        return $this;
    }

}